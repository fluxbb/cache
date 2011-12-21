<?php

require_once dirname(__FILE__).'/../Cache.php';

class Flux_Cache_FileTest extends Flux_CacheTest
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
