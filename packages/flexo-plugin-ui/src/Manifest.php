<?php

namespace Flexo\Plugin\Ui;

class Manifest extends \Flexo\Core\PluginManifest
{
	public function onRegister()
	{
		$this->app->get('/plugins', function($request, $response)
		{
			return $this->view->render($response, 'ui/plugins/home.twig', [
				'title' => 'Plugins Home',
			]);
		});
	}

	public function getResPath()
	{
		return dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'res';
	}

	public function getViewsPath()
	{
		return dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views';
	}
}
