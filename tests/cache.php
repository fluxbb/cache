<?php

require PHPCACHE_ROOT.'cache.php';

abstract class CacheTest extends PHPUnit_Framework_TestCase
{
	protected $cache;

	public function __construct($cache, $cache_args = array())
	{
		$this->cache = Cache::load($cache, $cache_args);
		$this->cache->clear();

		parent::__construct();
	}

	public function testClear()
	{
		// Stick some data in
		$this->cache->set('test.clear.1', 'hello');
		$this->cache->set('test.clear.2', 'hi');

		// Confirm its there
		$this->assertNotEquals($this->cache->get('test.clear.1'), Cache::NOT_FOUND);
		$this->assertNotEquals($this->cache->get('test.clear.2'), Cache::NOT_FOUND);

		// Clear the cache
		$this->cache->clear();

		// Confirm it has gone
		$this->assertEquals($this->cache->get('test.clear.1'), Cache::NOT_FOUND);
		$this->assertEquals($this->cache->get('test.clear.2'), Cache::NOT_FOUND);
	}

	public function testDelete()
	{
		// Stick some data in
		$this->cache->set('test.delete.1', 'hello');
		$this->cache->set('test.delete.2', 'hi');

		// Confirm its there
		$this->assertNotEquals($this->cache->get('test.delete.1'), Cache::NOT_FOUND);
		$this->assertNotEquals($this->cache->get('test.delete.2'), Cache::NOT_FOUND);

		// Delete item 1
		$this->cache->delete('test.delete.1');

		// Confirm only it has gone
		$this->assertEquals($this->cache->get('test.delete.1'), Cache::NOT_FOUND);
		$this->assertNotEquals($this->cache->get('test.delete.2'), Cache::NOT_FOUND);
	}

	public function testSet()
	{
		// Confirm the data is not there
		$this->assertEquals($this->cache->get('test.set'), Cache::NOT_FOUND);

		// Stick the data in
		$this->cache->set('test.set', 'hello');

		// Confirm it is there
		$this->assertNotEquals($this->cache->get('test.set'), Cache::NOT_FOUND);
	}

	public function testTTL()
	{
		// Confirm the data is not there
		$this->assertEquals($this->cache->get('test.ttl'), Cache::NOT_FOUND);

		// Stick the data in with a TTL of 1 second
		$this->cache->set('test.ttl', 'hello', 1);

		// Confirm it is there
		$this->assertNotEquals($this->cache->get('test.ttl'), Cache::NOT_FOUND);

		// Sleep for 2 seconds
		sleep(2);

		// Confirm it has gone
		$this->assertEquals($this->cache->get('test.ttl'), Cache::NOT_FOUND);
	}

	public function testGet()
	{
		$data = uniqid();

		// Stick the data in
		$this->cache->set('test.get', $data);

		// Confirm we get back the same data
		$this->assertEquals($this->cache->get('test.get'), $data);
	}
}
