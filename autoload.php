<?php

function customAutoloader($className): void
{
    $baseDirectory = __DIR__ . '/app/';

    $classPath = str_replace(['\\', 'Hive5/'], ['/', ''], $className) . '.php';

    $fullPath = $baseDirectory . $classPath;

    if (file_exists($fullPath)) {
        require_once $fullPath;
    }
}

spl_autoload_register('customAutoloader');