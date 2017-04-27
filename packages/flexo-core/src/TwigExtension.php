<?php

namespace Flexo\Core;

class TwigExtension extends \Twig_Extension
{
	protected $assets = [];

	public function __construct($container)
    {
        $this->container = $container;
    }

    public function getName()
    {
        return 'flexo';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('add_asset', [$this, 'addAsset']),
            new \Twig_SimpleFunction('get_assets', [$this, 'getAssets']),
            new \Twig_SimpleFunction('get_res_url', [$this, 'getResUrl']),
        ];
    }

    public function addAsset($tag, $url)
    {
    	if (empty($this->assets[$tag])) {
    		$this->assets[$tag] = [];
    	}
    	$this->assets[$tag][] = $url;
    }

    public function getAssets($tag)
    {
    	if (empty($this->assets[$tag])) {
    		return [];
    	}
    	return array_unique($this->assets[$tag]);
    }

    public function getResUrl($path)
    {
    	return $this->container->res->makePublicUrl($path);
    }
}
