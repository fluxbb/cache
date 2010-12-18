<?php

/**
 * The eAccelerator cache stores data using eAccelerator.
 * http://eaccelerator.net
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
 */

class Cache_eAccelerator extends Cache
{
	/**
	* Initialise a new eAccelerator cache.
	*/
	public function __construct($config)
	{
		if (!extension_loaded('eaccelerator') || !function_exists('eaccelerator_put')) // Some reason the user cache functions aren't available in 0.9.6.x...
			throw new Exception('The eAccelerator cache requires the eAccelerator extension with shared memory functions enabled.');
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

	protected function _delete($key)
	{
		eaccelerator_rm($key);
	}

	public function clear()
	{
		eaccelerator_clear();
	}
}
