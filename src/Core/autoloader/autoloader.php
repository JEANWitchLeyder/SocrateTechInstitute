<?php 
declare(strict_types = 1);

spl_autoload_register(function($classname){
 $directory = dirname(__DIR__);
 
 $file = $directory . str_replace("\\","/",$classname) . ".php";

 if(file_exists($file)){
    require_once($file);
    }else{
        die("File{$file} not inside the directory {$directory}");
    }
 });


?>