<?php

/**
 * Bootstrap file
 */

// Initialize the microtime
$startTime = microtime(true);
$memoryUsage = memory_get_usage();
ini_set('memory_limit', -1 );

// Set the root path
$rootDirectory = dirname(__FILE__);
$publicDirectory = "public_html";
$rootDirectory = substr($rootDirectory, 0, strlen($rootDirectory) - strlen($publicDirectory) - 1);
define("ROOTDIR", $rootDirectory);


// Include the configuration file
require(ROOTDIR . '/configuration/configuration.php');

// Define the default include path
set_include_path(PATH_SEPARATOR .
                 ROOTDIR . '/application/library/' .
				 PATH_SEPARATOR .
                 ROOTDIR . '/application/modules/default/models/' .
				 PATH_SEPARATOR .
                 ROOTDIR . '/application/modules/default/controllers/'
				);

// Register the Zend autoloader
require 'Zend/Loader/Autoloader.php';


try {

	$autoloader = Zend_Loader_Autoloader::getInstance();
	$autoloader->registerNamespace('Zend_');
	$autoloader->setFallbackAutoloader(true);

	// Initialize the application and run it
	$application = new Zend_Application(
	    APPLICATION_ENV,
	    ROOTDIR . '/configuration/application.ini'
	);

	$application->bootstrap();
	$application->run();

} catch (Exception $e) {

	var_dump($e);
	die();
	//console.log("error");

}
