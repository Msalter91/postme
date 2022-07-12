<?php
//load config

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'config/config.php';

// Require Interfaces
require '../app/code/Post/Api/Data/PostInterface.php';
require '../app/code/Post/Api/PostRepositoryInterface.php';

//Load helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';

// require models
require '../app/code/Post/Model/Post.php';
require '../app/code/Post/Model/PostRepository.php';
// load libraries
require 'libraries/core.php';
require 'libraries/controller.php';
require 'libraries/Database.php';





//Autoload core libraries
//spl_autoload_register(function($classNAme){
//    require 'libraries/'. $classNAme . '.php';
//});



