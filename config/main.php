<?php

return [
	'settings' => [
        'displayErrorDetails' => true,
        'homeTitle' => 'Flexo',
        'homeRoute' => 'plugins-home',
    ],
    'publicResPath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'res',
    'publicResUrl' => '/res',
    'plugins' => require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'plugins.php'),
    'pluginsEnabled' => require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'plugins-enabled.php'),
    'twigCachePath' => false,
];
