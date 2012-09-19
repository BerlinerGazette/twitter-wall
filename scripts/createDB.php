<?php

// Define application root directory
define('APPLICATION_ROOT', realpath(__DIR__ . '/..'));

// Define application path directory
define('APPLICATION_PATH', APPLICATION_ROOT . '/application');

// Define application library directory
define('APPLICATION_LIBRARY', APPLICATION_ROOT . '/library');

// Define application data directory
define('APPLICATION_DATA', APPLICATION_ROOT . '/data');

// Set library directory as include_path
set_include_path(APPLICATION_LIBRARY);

// Initialize autoloading
require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

// Define some CLI options
$getopt = new Zend_Console_Getopt(array(
	'env|e-s' => 'Application environment for which to create database (defaults to development)',
	'help|h' => 'Help -- usage message',
));

try {
	$getopt->parse();
} catch (Zend_Console_Getopt_Exception $e) {
	printf('Error: Bad options passed!' . PHP_EOL);
	printf('%s' . PHP_EOL, $getopt->getUsageMessage());
	return false;
}

// If help requested, report usage message
if ($getopt->getOption('h')) {
	printf('%s' . PHP_EOL, $getopt->getUsageMessage());
	return true;
}

// Define application environment (default is 'development')
define('APPLICATION_ENV', $getopt->getOption('e') ? $getopt->getOption('e') : 'development');

// Initialize Zend_Application
$application = new Zend_Application(
	APPLICATION_ENV,
	APPLICATION_PATH . '/configs/application.ini'
);

// Bootstrap
$bootstrap = $application->getBootstrap();

// Initialize directories
$bootstrap->bootstrap('directories');

// Initialize and retrieve DB resource
$bootstrap->bootstrap('db');
$dbAdapter = $bootstrap->getResource('db');

// let the user know whats going on (we are actually creating a database here)
printf('Writing Database "twitterwall" in (control-c to cancel): ' . PHP_EOL);
for ($x = 5; $x > 0; $x--) {
	printf('%s ', $x);
	sleep(1);
}
printf(PHP_EOL);

// Check to see if we have a database file already
$options = $bootstrap->getOption('resources');
$dbFile = $options['db']['params']['dbname'];

if (file_exists($dbFile)) {
	unlink($dbFile);
}

// this block executes the actual statements that were loaded from the schema file.
try {
	$sqlSchema = file_get_contents(dirname(__FILE__) . '/schema.twitterwall.sql');
	// use the connection directly to load sql in batches
	$dbAdapter->getConnection()->exec($sqlSchema);
	chmod($dbFile, 0644);

	printf('Database Created' . PHP_EOL);
} catch (Exception $e) {
	printf('An error occured:' . PHP_EOL);
	printf($e->getMessage() . PHP_EOL);
	return false;
}

// generally speaking, this script will be run from the command line
return true;
