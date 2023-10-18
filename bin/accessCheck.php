#!/usr/bin/php
<?php

use Hive5\Models\ModuleFunction;
use Hive5\Models\User;

require_once __DIR__ . '/../autoload.php';

$options = getopt("u:f:");

if (empty($options['u']) || empty($options['f'])) {
    exit('Required params have not been provided');
}

$user = User::findByName($options['u']);

if (!$user) {
    exit('User not found');
}

$moduleFunction = ModuleFunction::findByName($options['f']);
if (!$moduleFunction) {
    exit('Function not found');
}

if (!User::hasAccess($user, $moduleFunction)) {
    exit('User has no access to the function');
}

exit('User has access to the function');