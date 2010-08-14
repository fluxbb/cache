<?php

/**
 * The eAccelerator cache stores data using eAccelerator.
 * http://eaccelerator.net
 * 
 * Copyright (C) 2010 Jamie Furness
 * License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */

class Cache_eAccelerator extends Cache
{

	/**
	* Initialise a new eAccelerator cache.
	*/
	public function __construct($config)
	{

	}

	protected function _set($key, $data)
	{
		if (eaccelerator_put($key, $data) === false)
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
}
