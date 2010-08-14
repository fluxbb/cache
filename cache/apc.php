<?php

/**
 * The APC cache stores data using APC.
 * http://uk2.php.net/manual/en/book.apc.php
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */

class Cache_APC extends Cache
{

	/**
	* Initialise a new APC cache.
	*/
	public function __construct($config)
	{

	}

	protected function _set($key, $data)
	{
		if (apc_store($key, $data) === false)
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
}
