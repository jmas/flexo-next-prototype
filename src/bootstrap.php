<?php

define('CONFIG_DIR_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config');
define('CONFIG_PLUGINS_FILE_PATH', CONFIG_DIR_PATH . DIRECTORY_SEPARATOR . 'plugins.php');
define('CONFIG_PLUGINS_ENABLED_FILE_PATH', CONFIG_DIR_PATH . DIRECTORY_SEPARATOR . 'plugins-enabled.php');
define('CONFIG_MAIN_FILE_PATH', CONFIG_DIR_PATH . DIRECTORY_SEPARATOR . 'main.php');
define('PUBLIC_DIR_PATH', CONFIG_DIR_PATH . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public');
define('VENDOR_FILE_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

require_once(VENDOR_FILE_PATH);

$app = new \Flexo\Core\App(array_merge(require(CONFIG_MAIN_FILE_PATH), [
    'pluginsEnabledFilePath' => CONFIG_PLUGINS_ENABLED_FILE_PATH,
    'corePluginsList' => [
        \Flexo\Plugin\Core\Manifest::class,
        \Flexo\Plugin\Plugins\Manifest::class,
        \Flexo\Plugin\Users\Manifest::class,
    ],
    'publicResPath' => PUBLIC_DIR_PATH . DIRECTORY_SEPARATOR . 'res',
    'publicResUrl' => '/res',
    'plugins' => require(CONFIG_DIR_PATH . DIRECTORY_SEPARATOR . 'plugins.php'),
    'pluginsEnabled' => require(CONFIG_DIR_PATH . DIRECTORY_SEPARATOR . 'plugins-enabled.php'),
    'twigCachePath' => false,
]));
$app->run();
