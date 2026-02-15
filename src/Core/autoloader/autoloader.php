<?php
declare(strict_types=1);

spl_autoload_register(function (string $classname) {

    $baseDir = dirname(__DIR__, 2) . '/'; 
    $file = $baseDir . str_replace('\\', '/', $classname) . '.php';

    if (file_exists($file)) {
        require_once $file;
        return;
    }

    die("Autoload error: File {$file} not found. BaseDir={$baseDir}");
});


?>