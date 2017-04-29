<?php

namespace Flexo\Plugin\Users;

class Manifest extends \Flexo\Core\PluginManifest
{
	public function getName()
	{
		return 'Flexo Users';
	}

    public function getAuthorName()
    {
        return 'Alex Maslakov';
    }

    public function getAuthorEmail()
    {
        return 'jmas.ukraine@gmail.com';
    }

    public function getAuthorSiteUrl()
    {
        return 'http://flexo.github.io/';
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

    public function getDescription()
    {
        return file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'description.html');
    }
}
