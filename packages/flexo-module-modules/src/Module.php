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
            if ($app->saveModules($modules)) {
                $this->flash->addMessage('success', 'Successfully saved!');
            } else {
                $this->flash->addMessage('error', 'Save failed!');
            }
            return $response->withRedirect($this->router->pathFor('modules-home'));
        })->setName('modules-save');
        $currentModule = $this;
        $this->app->get('/modules/repository', function($request, $response) use ($app, $currentModule)
        {
            $renewCache = $request->getParam('renewCache', '0') === '1';
            if ($renewCache) {
                $currentModule->getModulesFromRepo(false);
                $this->flash->addMessage('success', 'Cache renewed!');
                return $response->withRedirect($this->router->pathFor('modules-repository'));
            }
            return $this->view->render($response, 'modules/repository.twig', [
                'title' => 'Modules Repository',
                'modules' => $currentModule->getModulesFromRepo(),
            ]);
        })->setName('modules-repository');
		$this->container->nav->addItem('Modules', 'modules-home', 'Settings');
	}

	protected function getModulesFromRepo($checkCache=true)
    {
        $cacheModulesPath = $this->app->getTempDirPath('modules') . DIRECTORY_SEPARATOR . 'modules.json';
        if ($checkCache) {
            if (file_exists($cacheModulesPath)) {
                $modulesContent = file_get_contents($cacheModulesPath);
                $modules = json_decode($modulesContent, true);
                if ($modules) {
                    return $modules;
                }
            }
        }
        $repoUrl = $this->container->modulesRepositoryUrl;
        $modulesContent = file_get_contents($repoUrl);
        if ($modulesContent) {
            $modules = json_decode($modulesContent, true);
            file_put_contents($cacheModulesPath, $modulesContent);
            if ($modules) {
                return $modules;
            }
        }
        return [];
    }
}
