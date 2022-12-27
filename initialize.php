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

require_once(LIB_PATH.DS.'blacklisted_devices.php');
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'csrf.php');
require_once(LIB_PATH.DS.'session.php');

?>