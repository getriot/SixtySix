<?php
namespace Sixtysix\Core;

class Autoloader
{
    public static function load($class) {
        $parts = explode('\\', $class);
        require end($parts) . '.class.php';
    }
}

spl_autoload_register(__NAMESPACE__ . '\\Autoloader::load');