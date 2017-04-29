<?php

namespace Flexo\Module\Users;

class Module extends \Flexo\Core\Module
{
    public function getRootPath()
    {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . '..';
    }

	public function onRegister()
	{
		$this->app->get('/users', function($request, $response)
		{
			return $this->view->render($response, 'users/home.twig');
		})->setName('user-home');
		$this->container->nav->addItem('Users', 'user-home', 'Settings');
	}
}
