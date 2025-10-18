<?php

ini_set('display_errors', '0');               // Don't show errors in browser (production safe)
ini_set('log_errors', '1');                   // Enable error logging
$logPath = __DIR__ . '/logs/error.log';
ini_set('error_log', $logPath);
//error_log(" Test log written at " . date('Y-m-d H:i:s'));

// Convert all warnings/notices to exceptions

/*
set_error_handler(function ($severity, $message, $file, $line) {
    throw new \ErrorException($message, 0, $severity, $file, $line);
});
*/
if (!file_exists(dirname($logPath))) {
    mkdir(dirname($logPath), 0775, true);
}
if (!file_exists($logPath)) {
    file_put_contents($logPath, '');
}
error_reporting(E_ALL);



//error_reporting(E_ALL);
//ini_set("display_errors", 1);
//Boostrapig the app

define("APP_DIR",__DIR__);

require_once("core/config.php");


session_start();

if(file_exists("vendor/autoload.php")){
    //Composer Directory AutoLoad
    require_once("vendor/autoload.php");
}

//App Directory AutoLoad
require_once("core/autoload.php");
require_once("core/setting.php");
require_once("core/app.php");


