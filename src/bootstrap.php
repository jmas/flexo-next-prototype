<?php

define('CONFIG_DIR_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config');
define('CONFIG_MODULES_FILE_PATH', CONFIG_DIR_PATH . DIRECTORY_SEPARATOR . 'modules.php');
define('CONFIG_MODULES_ENABLED_FILE_PATH', CONFIG_DIR_PATH . DIRECTORY_SEPARATOR . 'modules-enabled.php');
define('CONFIG_MAIN_FILE_PATH', CONFIG_DIR_PATH . DIRECTORY_SEPARATOR . 'main.php');
define('PUBLIC_DIR_PATH', CONFIG_DIR_PATH . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public');
define('VENDOR_FILE_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

require_once(VENDOR_FILE_PATH);

$app = new \Flexo\Core\App(array_merge(file_exists(CONFIG_MAIN_FILE_PATH) ? require(CONFIG_MAIN_FILE_PATH): [], [
    'publicResPath' => PUBLIC_DIR_PATH . DIRECTORY_SEPARATOR . 'res',
    'publicResUrl' => '/res',
    'modulesEnabledFilePath' => CONFIG_MODULES_ENABLED_FILE_PATH,
    'modules' => file_exists(CONFIG_MODULES_FILE_PATH) ? require(CONFIG_MODULES_FILE_PATH): [],
    'modulesEnabled' => file_exists(CONFIG_MODULES_ENABLED_FILE_PATH) ? require(CONFIG_MODULES_ENABLED_FILE_PATH): [],
    'modulesCore' => [
        \Flexo\Module\Core\Module::class,
        \Flexo\Module\Modules\Module::class,
        \Flexo\Module\Users\Module::class,
    ],
    'twigCachePath' => false,
    'pluginsRepositoryUrl' => 'http://127.0.0.1:8888/res/repository.json',
]));
$app->run();
