<?php

namespace Flexo\Module\Modules;

class Module extends \Flexo\Core\Module
{
    public function getRootPath()
    {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . '..';
    }

	public function onRegister()
	{
	    $app = $this->app;
		$this->app->get('/modules', function($request, $response) use ($app)
		{
            $modules = $app->getModules();
            $modulesList = [];
            foreach ($modules as $module) {
                $modulesList[] = [
                    'isEnabled' => $app->isModuleEnabled($module->getId()),
                    'isCore'    => $app->isModuleCore($module->getId()),
                    'module'    => $module,
                ];
            }
			return $this->view->render($response, 'modules/home.twig', [
				'title' => 'Modules Home',
                'modules' => $modulesList,
			]);
		})->setName('modules-home');
        $this->app->post('/modules/save', function($request, $response) use ($app)
        {
            $modules = $request->getParsedBodyParam('modules');
            $app->saveModules($modules);
            return $response->withRedirect($this->router->pathFor('modules-home'));
        })->setName('modules-save');
        $this->app->get('/modules/repository', function($request, $response) use ($app)
        {
            return $this->view->render($response, 'modules/repository.twig', [
                'title' => 'Modules Repository',
            ]);
        })->setName('modules-repository');
		$this->container->nav->addItem('Modules', 'modules-home', 'Settings');
	}
}
