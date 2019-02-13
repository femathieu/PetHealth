<?php

use Controller\UserController;

require_once(__DIR__ . '/log_writer.php');

$cutPath = explode('\\src', __DIR__);
$path = $cutPath[0] . '\\logs\server_error.log';

//set log path
ini_set('error_log', $path); 

// Logging file size
ini_set('log_errors_max_len', 2048); 

// setup log writer
$logWriter = new LogWriter();
$logWriter->setFile($path);
$logWriter->openFile();

spl_autoload_register(function($className){
    include __DIR__ . '\\class\\' . $className . '.class.php';
});

$userCtrl = new UserController(); 

///SRC

// close log file after finishing app
$logWriter->closeFile();