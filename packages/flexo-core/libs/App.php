<?php

namespace Flexo\Core;

class App extends \Slim\App
{
	protected $plugins = [];
    protected $pluginsEnabled = [];
	protected $viewsPaths = [];
	protected $resPaths = [];

	public function run($silent = false)
	{
		$this->registerNav();
		$this->registerPlugins();
		$this->registerPluginsEnabled();
		$this->registerViews();
		$this->registerResources();
		parent::run($silent);
	}

	public function enablePlugin($pluginManifestClassName)
	{
        $plugins = array_unique($this->getContainer()->pluginsEnabled);
        $plugins[] = $pluginManifestClassName;
        return $this->savePlugins($plugins);
	}

	public function disablePlugin($pluginManifestClassName)
	{
        $plugins = array_unique(array_merge($this->getContainer()->corePluginsList, $this->getContainer()->pluginsEnabled));
        return $this->savePlugins(array_diff($plugins, [$pluginManifestClassName]));
	}

	public function getPlugins()
    {
        return $this->plugins;
    }

    public function getPluginsEnabled()
    {
        return $this->pluginsEnabled;
    }

    public function isPluginEnabled($pluginManifestClassName)
    {
        return in_array($pluginManifestClassName, $this->getContainer()->pluginsEnabled);
    }

    public function isPluginCore($pluginManifestClassName)
    {
        return in_array($pluginManifestClassName, $this->getContainer()->corePluginsList);
    }

    public function savePlugins($newPlugins)
    {
        $pluginsEnabledFilePath = $this->getContainer()->pluginsEnabledFilePath;
        return file_put_contents($pluginsEnabledFilePath, '<' . '?php return ' . var_export($newPlugins, true) . ';') !== false;
    }

    protected function registerPlugins()
    {
        $plugins = array_unique($this->getContainer()->plugins);
        foreach ($plugins as $pluginClassName) {
            $plugin = new $pluginClassName($this);
            $this->plugins[] = $plugin;
        }
    }

	protected function registerPluginsEnabled()
	{
		$plugins = array_unique($this->getContainer()->pluginsEnabled);
		foreach ($plugins as $pluginClassName) {
			$plugin = new $pluginClassName($this);
			$plugin->onRegister();
			$this->pluginsEnabled[] = $plugin;
		}
	}

	protected function registerViews()
	{
		foreach ($this->plugins as $plugin) {
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
			return $view;
		};
	}

	protected function registerResources()
	{
		foreach ($this->plugins as $plugin) {
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
}
