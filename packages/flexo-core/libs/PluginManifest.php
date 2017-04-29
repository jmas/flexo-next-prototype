<?php

namespace Flexo\Core;

abstract class PluginManifest {
	protected $app;
	protected $container;

	public function __construct(\Flexo\Core\App $app)
	{
		$this->app = $app;
		$this->container = $this->app->getContainer();
	}

	public function getId()
    {
        return get_class($this);
    }

	public function getResPath()
	{
		return null;
	}

	public function getViewsPath()
	{
		return null;
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

    public function getAuthorName()
    {
        return null;
    }

    public function getAuthorEmail()
    {
        return null;
    }

    public function getAuthorSiteUrl()
    {
        return null;
    }

	public function getDescription()
    {
        return null;
    }

    public function hasDescription()
    {
        return $this->getDescription() !== null;
    }

	abstract public function getName();
}
