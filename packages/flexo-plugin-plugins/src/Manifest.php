<?php

namespace Flexo\Plugin\Plugins;

class Manifest extends \Flexo\Core\PluginManifest
{
	public function getName()
	{
		return 'Flexo Plugins';
	}

	public function onRegister()
	{
	    $app = $this->app;
		$this->app->get('/plugins', function($request, $response) use ($app)
		{
            $plugins = $app->getPlugins();
            $pluginsList = [];
            foreach ($plugins as $plugin) {
                $pluginsList[] = [
                    'isEnabled' => $app->isPluginEnabled($plugin->getId()),
                    'isCore' => $app->isPluginCore($plugin->getId()),
                    'plugin' => $plugin,
                ];
            }
			return $this->view->render($response, 'plugins/home.twig', [
				'title' => 'Plugins Home',
                'pluginsList' => $pluginsList,
			]);
		})->setName('plugins-home');
        $this->app->post('/plugins/save', function($request, $response) use ($app)
        {
            $plugins = $request->getParsedBodyParam('plugins');
            $app->savePlugins($plugins);
            return $response->withRedirect($this->router->pathFor('plugins-home'));
        })->setName('plugins-save');
		$this->container->nav->addItem('Plugins', 'plugins-home', 'Settings');
	}

	public function getViewsPath()
	{
		return dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views';
	}

	public function getDescription()
    {
        return file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'description.html');
    }
}
