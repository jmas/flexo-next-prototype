<?php

namespace Flexo\Plugin\Users;

class Manifest extends \Flexo\Core\PluginManifest
{
	public function getName()
	{
		return 'Flexo Users';
	}

	public function canBeDisabled()
	{
		return false;
	}

	public function getResPath()
	{
		return dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'res';
	}

	public function getViewsPath()
	{
		return dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views';
	}

	public function onRegister()
	{
		$this->app->get('/users', function($request, $response)
		{
			return $this->view->render($response, 'users/home.twig');
		})->setName('user-home');
		$this->container->nav->addItem('Users', 'user-home');
	}
}
