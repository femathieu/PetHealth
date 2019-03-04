<?php

use Controller\UserController;
use Slim\Http\Response;
use Slim\Http\Request;

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/log_writer.php');
require_once('../config/config.php');

//set log path
ini_set('error_log', $path); 

// Logging file size
ini_set('log_errors_max_len', 2048); 

// error_reporting(-1);
// ini_set('display_errors', 1);

spl_autoload_register(function($className){
    $file = __DIR__ . '/class/' . str_replace('\\', '/', $className) . '.class.php';
    if(file_exists($file)){
        include $file;
    }
});

$app = new \Slim\App($config);

$container = $app->getContainer();
$container['logger'] = function($c) {
    $cutPathLog = explode('/src', __DIR__);
    $pathLog = $cutPathLog[0] . '/logs/server_error.log';
    $logger = new \Monolog\Logger('app_logger');
    $file_handler = new \Monolog\Handler\StreamHandler($pathLog);
    $logger->pushHandler($file_handler);
    return $logger;
};

$app->getContainer()->logger->addInfo('start session');

require_once(__DIR__ . '/WS/user.php');

$app->run();

