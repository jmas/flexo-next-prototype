<?php

namespace Flexo\Module\Core;

class Module extends \Flexo\Core\Module
{
    public function getRootPath()
    {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . '..';
    }
}
