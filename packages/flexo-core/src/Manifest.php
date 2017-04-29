<?php

namespace Flexo\Plugin\Core;

class Manifest extends \Flexo\Core\PluginManifest
{
	public function getName()
	{
		return 'Flexo Core';
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

    public function getDescription()
    {
        return file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'description.html');
    }
}
