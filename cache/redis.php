<?php

/**
 * The Redis cache stores data using Redis via the phpredis extension.
 * http://github.com/owlient/phpredis
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */

class Cache_Redis extends Cache
{
	const DEFAULT_HOST = 'localhost';
	const DEFAULT_PORT = 6379;

	private $redis;

	/**
	* Initialise a new Redis cache.
	* 
	* @param	host	The redis server host, defaults to localhost
	* @param	port	The redis server port, defaults to 6379
	*/
	public function __construct($config)
	{
		if (!extension_loaded('redis'))
			throw new Exception('The Redis cache requires the Redis extension.');

		$host = isset($config['host']) ? $config['host'] : self::DEFAULT_HOST;
		$port = isset($config['port']) ? $config['port'] : self::DEFAULT_PORT;

		$this->redis = new Redis();
		$this->redis->connect($host, $port);
	}

	protected function _set($key, $data)
	{
		if ($this->redis->set($key, $data) === false)
			throw new Exception('Unable to write redis cache: '.$key);
	}

	protected function _get($key)
	{
		$data = $this->redis->get($key);
		if ($data === false)
			return self::NOT_FOUND;

		return $data;
	}

	public function delete($key)
	{
		$this->redis->delete($key);
	}

	public function clear()
	{
		$this->redis->flushDB();
	}
}
