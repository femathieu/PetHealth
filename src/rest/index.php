<?php

use Controller\UserController;
use Slim\Http\Response;
use Slim\Http\Request;

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/log_writer.php');

$cutPath = explode('/src', __DIR__);
$path = $cutPath[0] . '/logs/server_error.log';

//set log path
ini_set('error_log', $path); 

// Logging file size
ini_set('log_errors_max_len', 2048); 

// error_reporting(-1);
// ini_set('display_errors', 1);
 
// setup log writer
$logWriter = new LogWriter();
$logWriter->setFile($path);
$logWriter->openFile();

spl_autoload_register(function($className){
    include __DIR__ . '/class/' . str_replace('\\', '/', $className) . '.class.php';
});

$app = new \Slim\App;

require_once(__DIR__ . '/WS/user.php');

$app->run();

// close log file after finishing app
$logWriter->closeFile();
