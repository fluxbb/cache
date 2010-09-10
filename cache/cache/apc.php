<?php

/**
 * The APC cache stores data using APC.
 * http://uk2.php.net/manual/en/book.apc.php
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
 */

class Cache_APC extends Cache
{
	/**
	* Initialise a new APC cache.
	*/
	public function __construct($config)
	{
		if (!extension_loaded('apc'))
			throw new Exception('The APC cache requires the APC extension.');
	}

	// Since we are emulating the TTL we need to override set()
	public function set($key, $data, $ttl = 0)
	{
		// APC does support TTL however not within a single session so lets emulate it
		$data = array('expire' => $ttl > 0 ? time() + $ttl : 0, 'data' => $data);

		parent::set($key, $data, $ttl);
	}

	protected function _set($key, $data, $ttl)
	{
		if (apc_store($key, $data, $ttl) === false)
			throw new Exception('Unable to write APC cache: '.$key);
	}

	// Since we are emulating the TTL we need to override get()
	public function get($key)
	{
		$data = parent::get($key);
		if ($data === self::NOT_FOUND)
			return self::NOT_FOUND;

		// Check if the data has expired
		if ($data['expire'] > 0 && $data['expire'] < time())
		{
			$this->delete($key);

			// Correct the hit/miss counts
			$this->hits--;
			$this->misses++;

			return self::NOT_FOUND;
		}

		return $data['data'];
	}

	protected function _get($key)
	{
		$data = apc_fetch($key);
		if ($data === false)
			return self::NOT_FOUND;

		return $data;
	}

	protected function _delete($key)
	{
		apc_delete($key);
	}

	public function clear()
	{
		apc_clear_cache('user');
	}
}
