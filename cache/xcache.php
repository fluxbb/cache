<?php

/**
 * The XCache cache stores data using XCache.
 * http://xcache.lighttpd.net
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */

class Cache_XCache extends Cache
{
	const EMULATE_TTL = false;

	/**
	* Initialise a new XCache cache.
	*/
	public function __construct($config)
	{
		if (!extension_loaded('xcache'))
			throw new Exception('The XCache cache requires the XCache extension.');
	}

	protected function _set($key, $data, $ttl)
	{
		if (xcache_set($key, $data, $ttl) === false)
			throw new Exception('Unable to write xcache cache: '.$key);
	}

	protected function _get($key)
	{
		$data = xcache_get($key);
		if ($data === null)
			return self::NOT_FOUND;

		return $data;
	}

	public function delete($key)
	{
		xcache_unset($key);
	}

	public function clear()
	{
		xcache_clear_cache(XC_TYPE_VAR, 0);
	}
}
