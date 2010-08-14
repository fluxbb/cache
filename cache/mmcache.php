<?php

/**
 * The MMCache cache stores data using MMCache.
 * http://turck-mmcache.sourceforge.net
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */

class Cache_MMCache extends Cache
{

	/**
	* Initialise a new MMCache cache.
	*/
	public function __construct($config)
	{

	}

	protected function _set($key, $data)
	{
		if (mmcache_put($key, $data) === false)
			throw new Exception('Unable to write MMCache cache: '.$key);
	}

	protected function _get($key)
	{
		$data = mmcache_get($key);
		if ($data === null)
			return self::NOT_FOUND;

		return $data;
	}

	public function delete($key)
	{
		mmcache_rm($key);
	}
}
