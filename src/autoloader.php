<?php

function autoload($class) {
    $baseDir = __DIR__ . '/../src/';

    $class = str_replace('\\', '/', $class);
    if (strpos($class, 'Controller') !== false) {
        $file = $baseDir . 'controller/' . $class . '.php';  
    } elseif (strpos($class, 'Model') !== false) {
        $file = $baseDir . 'model/' . $class . '.php'; 
    } else {
        $file = $baseDir . $class . '.php';
    }

    if (file_exists($file)) {
        require_once $file;
    } else {
        echo "Class file for '$class' not found at '$file'";
    }
}

spl_autoload_register('autoload');
