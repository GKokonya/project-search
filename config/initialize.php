<?php
date_default_timezone_set('Africa/Nairobi');
//Define the core paths
//Define them as absolute paths to make sure require_once works as expected

//DIRECTORY SEPARATOR is a PHP pre_defined constant 
//((\ for Windows))
defined('DS')? null : define('DS',DIRECTORY_SEPARATOR);
defined('SITE_ROOT')? null: define('SITE_ROOT',DS.'home'.DS.'itncoke1'.DS.'projectsearch.itn3.co.ke');
//\xampp\htdocs\Pepea
defined('LIB_PATH')? null: define('LIB_PATH',SITE_ROOT.DS.'config');

//Name of Site
define('SITE_NAME','Project Search');

//Currency
define('CURRENCY','kES');

require_once(LIB_PATH.DS.'blacklisted_devices.php');
//Database Class
require_once(LIB_PATH.DS.'database.php');
//CSRF Tokekn  Class
require_once(LIB_PATH.DS.'csrf.php');
//Session Class
require_once(LIB_PATH.DS.'session.php');
//InCompleteSearch Class
require_once(LIB_PATH.DS.'incomplete_search.php');
//Utility Class
require_once(LIB_PATH.DS.'utility.php');
//InCompleteSearch Class
require_once(LIB_PATH.DS.'complete_Search.php');
//Sending emails
require_once(LIB_PATH.DS."email.php");
//Sending users
require_once(LIB_PATH.DS."user.php");
//M-Pesa classes
require_once(LIB_PATH.DS."ExpressCheckout".DS."mpesa.php");
require_once(LIB_PATH.DS."ExpressCheckout".DS."mpesadb.php");
?>