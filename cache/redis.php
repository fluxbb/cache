<?php

/**
 * The Redis cache stores data using Redis via the phpredis extension.
 * http://github.com/owlient/phpredis
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
 */

class Cache_Redis extends Cache
{
	const EMULATE_TTL = false;

	const DEFAULT_HOST = 'localhost';
	const DEFAULT_PORT = 6379;

	private $redis;

	/**
	* Initialise a new Redis cache.
	* 
	* @param	instance	An existing Redis instance to reuse (if
							specified the other params are ignored)
	* @param	host		The redis server host, defaults to localhost
	* @param	port		The redis server port, defaults to 6379
	*/
	public function __construct($config)
	{
		if (!extension_loaded('redis'))
			throw new Exception('The Redis cache requires the Redis extension.');

		// If we were given a Redis instance use that
		if (isset($config['instance']))
			$this->redis = $config['instance'];
		else
		{
			$host = isset($config['host']) ? $config['host'] : self::DEFAULT_HOST;
			$port = isset($config['port']) ? $config['port'] : self::DEFAULT_PORT;

			$this->redis = new Redis();
			if (@$this->redis->connect($host, $port) === false)
				throw new Exception('Unable to connect to redis server: '.$host.':'.$port);
		}
	}

	protected function _set($key, $data, $ttl)
	{
		if ($this->redis->set($key, $data) === false)
			throw new Exception('Unable to write redis cache: '.$key);

		if ($ttl > 0 && $this->redis->expire($key, $ttl) === false)
			throw new Exception('Unable to set TTL on cache: '.$key);
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
