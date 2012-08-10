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

// Initialize DB
$bootstrap->bootstrap('db');

$tweetModel = new Application_Model_Tweet();
$tweetModel->id = time();
$tweetModel->createdAt = "Fri, 10 Aug 2012 12:23:43 +0000";

$tweetMapper = new Application_Model_TweetMapper();
$tweetMapper->save($tweetModel);

$tweets = $tweetMapper->fetchAll();

foreach ($tweets as $tweet) {
    printf('%d: %s', $tweet->id, $tweet->createdAt . PHP_EOL);
}
 
// generally speaking, this script will be run from the command line
return true;
