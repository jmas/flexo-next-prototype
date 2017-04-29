<?php

namespace Flexo\Core;
use Symfony\Component\Filesystem\Filesystem;

class App extends \Slim\App
{
	protected $modules = [];
    protected $modulesEnabled = [];
	protected $viewsPaths = [];
	protected $resPaths = [];
	protected $fs;

	public function run($silent = false)
	{
        session_start();
        $this->fs = new Filesystem();
        $this->registerFlash();
		$this->registerNav();
		$this->registerModules();
		$this->registerModulesEnabled();
		$this->registerViews();
		$this->registerResources();
		parent::run($silent);
	}

	public function getModules()
    {
        return $this->modules;
    }

    public function getModulesEnabled()
    {
        return $this->modulesEnabled;
    }

    public function isModuleEnabled($pluginManifestClassName)
    {
        return in_array($pluginManifestClassName, $this->getContainer()->modulesEnabled);
    }

    public function isModuleCore($pluginManifestClassName)
    {
        return in_array($pluginManifestClassName, $this->getContainer()->modulesCore);
    }

    public function saveModules(array $modulesList)
    {
        $modulesEnabledFilePath = $this->getContainer()->modulesEnabledFilePath;
        return file_put_contents($modulesEnabledFilePath, '<' . '?php return ' . var_export($modulesList, true) . ';') !== false;
    }

    public function getTempDirPath($dirName)
    {
        $tempDirPath = $this->getContainer()->tempDirPath . DIRECTORY_SEPARATOR . $dirName;
        $this->fs->mkdir($tempDirPath, 0700);
        return $tempDirPath;
    }

    protected function registerModules()
    {
        $modules = array_unique($this->getContainer()->modules);
        foreach ($modules as $moduleClassName) {
            $module = new $moduleClassName($this);
            $this->modules[] = $module;
        }
    }

	protected function registerModulesEnabled()
	{
		$modules = array_unique($this->getContainer()->modulesEnabled);
		foreach ($modules as $moduleClassName) {
			$module = new $moduleClassName($this);
			$module->onRegister();
			$this->modulesEnabled[] = $module;
		}
	}

	protected function registerViews()
	{
		foreach ($this->modules as $plugin) {
			$viewsPath = $plugin->getViewsPath();
			if ($viewsPath) {
				$this->viewsPaths[] = $viewsPath;
			}
		}
		$container = $this->getContainer();
		$container['view'] = function($container) {
			$view = new \Slim\Views\Twig($this->viewsPaths, [
			    'cache' => $container->twigCachePath,
			]);
			$view->addExtension(new \Slim\Views\TwigExtension($container['router'], $container->request->getUri()));
			$view->addExtension(new TwigExtension($container));
			$view->offsetSet('nav', $container->nav);
            $view->offsetSet('settings', $container->settings);
            $view->offsetSet('flash', $container->flash);
			return $view;
		};
	}

	protected function registerResources()
	{
		foreach ($this->modules as $plugin) {
			$resPath = $plugin->getResPath();
			if ($resPath) {
				$this->resPaths[] = $resPath;
			}
		}
		$resPaths = $this->resPaths;
		$container = $this->getContainer();
		$container['res'] = function($container) use ($resPaths) {
			return new Resources(
				$resPaths,
				$container->publicResPath,
				$container->publicResUrl
			);
		};
	}

	protected function registerNav()
	{
		$container = $this->getContainer();
		$container['nav'] = function($container) {
			return new Nav();
		};
	}

	protected function registerFlash()
    {
        $container = $this->getContainer();
        $container['flash'] = function () {
            return new \Slim\Flash\Messages();
        };
    }
}
