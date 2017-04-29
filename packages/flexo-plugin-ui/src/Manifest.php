<?php

namespace Flexo\Plugin\Ui;

class Manifest extends \Flexo\Core\PluginManifest
{
	public function getName()
	{
		return 'Flexo UI';
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
}
