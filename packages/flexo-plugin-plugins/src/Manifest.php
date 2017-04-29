<?php

namespace Flexo\Plugin\Plugins;

class Manifest extends \Flexo\Core\PluginManifest
{
	public function getName()
	{
		return 'Flexo Plugins';
	}

	public function canBeDisabled()
	{
		return false;
	}

	public function onRegister()
	{
		$this->app->get('/plugins', function($request, $response)
		{
			return $this->view->render($response, 'plugins/home.twig', [
				'title' => 'Plugins Home',
			]);
		})->setName('plugins-home');
		$this->container->nav->addItem('Plugins', 'plugins-home', 'Settings');
	}

	public function getViewsPath()
	{
		return dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views';
	}
}
