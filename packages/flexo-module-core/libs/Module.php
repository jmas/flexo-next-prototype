<?php

namespace Flexo\Core;

abstract class Module {
	protected $app;
	protected $container;
	protected $manifest=[];

	public function __construct(\Flexo\Core\App $app)
	{
		$this->app = $app;
		$this->container = $this->app->getContainer();
	}

	public function getManifest()
    {
        if (empty($this->manifest)) {
            $this->manifest = json_decode(file_get_contents($this->getRootPath() . DIRECTORY_SEPARATOR . 'manifest.json'), true);
        }
        return $this->manifest;
    }

	public function getId()
    {
        return get_class($this);
    }

	public function getResPath()
	{
		return $this->getRootPath() . DIRECTORY_SEPARATOR . 'res';
	}

	public function getViewsPath()
	{
        return $this->getRootPath() . DIRECTORY_SEPARATOR . 'views';
	}

	public function onEnable()
	{
		return true;
	}

	public function onDisable()
	{
		return false;
	}

	public function onRegister()
	{
		return null;
	}

    public function getName()
    {
        return $this->getManifest()['name'];
    }

    public function getAuthors()
    {
        return $this->getManifest()['authors'];
    }

    public function hasAuthors()
    {
        return !empty($this->getManifest()['authors']);
    }

    public function getDescription()
    {
        $manifest = $this->getManifest();
        return !empty($manifest['description']) ? $manifest['description']: null;
    }

    public function hasDescription()
    {
        $manifest = $this->getManifest();
        return !empty($manifest['description']);
    }

    abstract function getRootPath();
}
