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

// Initialize Twitter
$bootstrap->bootstrap('twitter');

// Twitter search
$twitterOptions = Zend_Registry::get('twitter')->options;
$twitterQuery = Zend_Registry::get('twitter')->query;
$twitterMaxPages = Zend_Registry::get('twitter')->max_pages;

$twitterSearch = new Zend_Service_Twitter_Search('json');
$tweetMapper = new Application_Model_TweetMapper();

$tweetModel = new Application_Model_Tweet();
$sinceId = $tweetMapper->getDBTable()->findMaxIdByQuery($twitterQuery)->maxId;
if ($sinceId !== null) {
	$twitterOptions['since_id'] = $sinceId;
	printf('Set since_id: %s' . PHP_EOL, $sinceId);
}

$page = 1;

do {
	printf('Page: %d' . PHP_EOL, $page);
	$twitterOptions['page'] = $page;

	try {
		$searchResults = $twitterSearch->search($twitterQuery, $twitterOptions);
	} catch (Zend_Http_Client_Exception $exception) {
		printf('Exception: %s' . PHP_EOL, $exception->getMessage());
		continue;
	}

	if (isset($searchResults['error'])) {
		printf('Error: %s' . PHP_EOL, $searchResults['error']);
		continue;
	}

	foreach ($searchResults['results'] as $result) {
		$tweetModel = new Application_Model_Tweet();

		if ($tweetMapper->find($result['id'], $tweetModel)) {
			// printf('Not saved: %d' . PHP_EOL, $result['id']);
			continue;
		}

		$tweetModel->id = $result['id'];
		$tweetModel->idStr = $result['id_str'];
		$tweetModel->query = $twitterQuery;
		$tweetModel->fromUser = $result['from_user'];
		$tweetModel->fromUserIdStr = $result['from_user_id_str'];
		$tweetModel->fromUserName = $result['from_user_name'];
		$tweetModel->source = $result['source'];
		$tweetModel->text = $result['text'];
		$tweetModel->createdAt = $result['created_at'];

		$tweetMapper->save($tweetModel);

		// printf('New saved: %d' . PHP_EOL, $result['id']);
	}

	if (empty($searchResults['results'])) {
		$page = $twitterMaxPages;
		printf('No more search results found.' . PHP_EOL);
		continue;
	}

	sleep(mt_rand(1, 5));
} while ($page++ < $twitterMaxPages);

// $tweets = $tweetMapper->fetchAll();

// foreach ($tweets as $tweet) {
// 	printf('%d (%s): %s', $tweet->id, $tweet->query, $tweet->createdAt . PHP_EOL);
// }

// generally speaking, this script will be run from the command line
return true;
