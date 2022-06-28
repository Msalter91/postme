<?php
//load config
require_once 'config/config.php';

// load libraries
require 'libraries/core.php';
require 'libraries/controller.php';


//Autoload core libraries
spl_autoload_register(function($classNAme){
    require 'libraries/'. $classNAme . '.php';
});

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);