<?php

require_once dirname(__FILE__).'/../Cache.php';

class Flux_Cache_XCacheTest extends Flux_CacheTest
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
