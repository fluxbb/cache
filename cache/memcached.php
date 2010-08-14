<?php

/**
 * The Memcached cache stores data using the Memcached extension for Memcached.
 * http://uk2.php.net/manual/en/book.memcached.php
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
 */

class Cache_Memcached extends Cache
{
	const EMULATE_TTL = false;

	const DEFAULT_HOST = 'localhost';
	const DEFAULT_PORT = 11211;

	private $memcached;

	/**
	* Initialise a new Memcached cache.
	* 
	* @param	instance	An existing Memcached instance to reuse (if
							specified the other params are ignored)
	* @param	host		The memcached server host, defaults to localhost
	* @param	port		The memcached server port, defaults to 11211
	*/
	public function __construct($config)
	{
		if (!extension_loaded('memcached'))
			throw new Exception('The Memcached cache requires the Memcached extension.');

		// If we were given a Memcached instance use that
		if (isset($config['instance']))
			$this->memcached = $config['instance'];
		else
		{
			$host = isset($config['host']) ? $config['host'] : self::DEFAULT_HOST;
			$port = isset($config['port']) ? $config['port'] : self::DEFAULT_PORT;

			$this->memcached = new Memcached();
			if (@$this->memcached->addServer($host, $port) === false)
				throw new Exception('Unable to connect to memcached server: '.$host.':'.$port);
		}
	}

	protected function _set($key, $data, $ttl)
	{
		if ($this->memcached->set($key, $data, $ttl) === false)
			throw new Exception('Unable to write memcached cache: '.$key);
	}

	protected function _get($key)
	{
		$data = $this->memcached->get($key);
		if ($data === false)
			return self::NOT_FOUND;

		return $data;
	}

	public function delete($key)
	{
		$this->memcached->delete($key);
	}

	public function clear()
	{
		$this->memcached->flush();
	}
}
