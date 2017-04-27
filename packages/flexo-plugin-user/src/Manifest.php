<?php

namespace Flexo\Plugin\User;

class Manifest extends \Flexo\Core\PluginManifest
{
	public function getResPath()
	{
		return dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'res';
	}

	public function getViewsPath()
	{
		return dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views';
	}
}
