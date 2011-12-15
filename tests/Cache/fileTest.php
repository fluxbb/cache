<?php

require_once dirname(__FILE__).'/../cache.php';

class Cache_FileTest extends CacheTestCase
{
	public static function setUpBeforeClass()
	{
		self::$cache = Flux_Cache::load('File', array('dir' => '/tmp/fluxbb-cache'));
	}

	public static function tearDownAfterClass()
	{
		self::$cache->clear();
		self::$cache = null;
	}
}
