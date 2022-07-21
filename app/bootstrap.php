<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'config/config.php';

// Require Interfaces
require '../app/code/Post/Api/Data/PostInterface.php';
require '../app/code/Post/Api/PostRepositoryInterface.php';
require '../app/code/User/Api/Data/UserInterface.php';
require '../app/code/User/Api/UserRepositoryInterface.php';

//Load helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';
require_once 'helpers/error_helper.php';
require_once 'helpers/Form_Key.php';

// require models
require '../app/code/Post/Model/Post.php';
require '../app/code/Post/Model/PostRepository.php';
require '../app/code/User/Model/User.php';
require '../app/code/User/Model/UserRepository.php';

// load libraries
require 'libraries/core.php';
require 'libraries/controller.php';
require 'libraries/Database.php';
