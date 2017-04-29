<?php

namespace Flexo\Core;

class App extends \Slim\App
{
	protected $plugins = [];
	protected $viewsPaths = [];
	protected $resPaths = [];

	public function run($silent = false)
	{
		$this->registerNav();
		$this->registerEnabledPlugins();
		$this->registerViews();
		$this->registerResources();
		parent::run($silent);
	}

	public function enablePlugin($manifestClassName)
	{
		
	}

	public function disablePlugin($manifestClassName)
	{

	}

	protected function registerEnabledPlugins()
	{
		$plugins = $this->getContainer()->pluginsEnabled;
		foreach ($plugins as $pluginClassName) {
			$plugin = new $pluginClassName($this);
			$plugin->onRegister();
			$this->plugins[] = $plugin;
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
			//'cache' => 'path/to/cache'
			]);
			$view->addExtension(new \Slim\Views\TwigExtension($container['router'], $container->request->getUri()));
			$view->addExtension(new TwigExtension($container));
			$view->offsetSet('nav', $container->nav);
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
			$publicResPath = $this->publicResPath;
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
