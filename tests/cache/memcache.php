<?php

define('PHPCACHE_ROOT', dirname(__FILE__).'/../../cache/');
require PHPCACHE_ROOT.'../tests/cache.php';

class MemCacheTest extends CacheTest
{
	public function __construct()
	{
		parent::__construct('memcache', array('host' => 'localhost', 'port' => 11211));
	}
}
