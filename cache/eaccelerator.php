<?php

/**
 * The eAccelerator cache stores data using eAccelerator.
 * http://eaccelerator.net
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */

class Cache_eAccelerator extends Cache
{
	const EMULATE_TTL = false;

	/**
	* Initialise a new eAccelerator cache.
	*/
	public function __construct($config)
	{
		if (!extension_loaded('eaccelerator'))
			throw new Exception('The eAccelerator cache requires the eAccelerator extension.');
	}

	protected function _set($key, $data, $ttl)
	{
		if (eaccelerator_put($key, $data, $ttl) === false)
			throw new Exception('Unable to write eAccelerator cache: '.$key);
	}

	protected function _get($key)
	{
		$data = eaccelerator_get($key);
		if ($data === null)
			return self::NOT_FOUND;

		return $data;
	}

	public function delete($key)
	{
		eaccelerator_rm($key);
	}

	public function clear()
	{
		eaccelerator_clear();
	}
}
