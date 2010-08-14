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
	const EMULATE_TTL = false;

	/**
	* Initialise a new APC cache.
	*/
	public function __construct($config)
	{
		if (!extension_loaded('apc'))
			throw new Exception('The APC cache requires the APC extension.');
	}

	protected function _set($key, $data, $ttl)
	{
		if (apc_store($key, $data, $ttl) === false)
			throw new Exception('Unable to write APC cache: '.$key);
	}

	protected function _get($key)
	{
		$data = apc_fetch($key);
		if ($data === false)
			return self::NOT_FOUND;

		return $data;
	}

	public function delete($key)
	{
		apc_delete($key);
	}

	public function clear()
	{
		apc_clear_cache('user');
	}
}
