<?php
spl_autoload_register(function ($class_name) {
    $directories = [
        "./config/",
        "./Classes/"
    ];

    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            include $file;
            break;
        }
    }
});