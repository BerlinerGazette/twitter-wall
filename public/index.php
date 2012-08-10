<?php

// Define application root directory
define('APPLICATION_ROOT', realpath(__DIR__ . '/..'));

// Define application path directory
define('APPLICATION_PATH', APPLICATION_ROOT . '/application');

// Define application library directory
define('APPLICATION_LIBRARY', APPLICATION_ROOT . '/library');

// Define application data directory
define('APPLICATION_DATA', APPLICATION_ROOT . '/data');

// Define application environment (default is 'development')
define('APPLICATION_ENV', getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development');

// Set library directory as include_path
set_include_path(APPLICATION_LIBRARY);

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();
