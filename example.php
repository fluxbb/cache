<?php

header('Content-type: text/plain');

require 'cache.php';

try
{
	// We want a file-based cache in the /tmp/php-cache/ dir - this will be created if possible. Obviously this path wont work on Windows!
	$cache = Cache::load('file', array('dir' => '/tmp/php-cache/'));

	// If we have the mcrypt extension lets encrypt the cache
	if (extension_loaded('mcrypt'))
	{
		echo 'Adding mcrypt filter.'."\n";
		$cache->add_filter('mcrypt', array('secret' => 'i like ponies'));
	}
}
catch (Exception $e)
{
	exit($e->getMessage());
}

// Check if there is already a value cached
$value = $cache->get('test');
echo ($value === Cache::NOT_FOUND ? 'Value not found in cache.' : 'Value: '.$value)."\n";

// Store a new unique ID in the cache
$uniqid = uniqid();

echo 'Storing: '.$uniqid."\n";
$cache->set('test', $uniqid);

// Check that the new value was stored correctly
$value = $cache->get('test');
echo ($value === Cache::NOT_FOUND ? 'Value not found in cache.' : 'Value: '.$value)."\n";
