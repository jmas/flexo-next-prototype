<?php

namespace Flexo\Core;

abstract class PluginManifest {
	protected $app;

	public function __construct(\Flexo\Core\App $app)
	{
		$this->app = $app;
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
		return void;
	}
}
