<?php

require_once dirname(__FILE__).'/../cache.php';

class Cache_XCacheTest extends CacheTestCase
{
	public static function setUpBeforeClass()
	{
		self::$cache = Flux_Cache::load('XCache');
	}

	public static function tearDownAfterClass()
	{
		self::$cache->clear();
		self::$cache = null;
	}
}
