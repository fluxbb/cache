<?php

define('PHPCACHE_ROOT', realpath(dirname(__FILE__).'/../').'/');
require PHPCACHE_ROOT.'cache.php';

abstract class CacheTestCase extends PHPUnit_Framework_TestCase
{
	protected static $cache;

	/**
	 * @dataProvider provider
	 */
	public function testGetSet($key, $value)
	{
		self::$cache->set($key, $value);

		$result = self::$cache->get($key);
		$this->assertEquals($result, $value);
	}

	public function testDelete()
	{
		$key = 'test';

		self::$cache->set($key, time());
		self::$cache->delete($key);

		$result = self::$cache->get($key);
		$this->assertEquals($result, Cache::NOT_FOUND);
	}

	public function provider()
	{
		return array(
			array('int', time()),
			array('string', 'hello world'),
			array('bool', true),
			array('null', null),
			array('array', array(0 => 'zero', 1 => 'one', 7 => 'seven')),
			array('object', new DOMComment('hello world')),
		);
	}
}
