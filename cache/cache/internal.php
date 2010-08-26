<?php

/**
 * The internal cache stores data internally using arrays.
 * This cache will not persist across requests, so in most cases is useless!
 * It's main purpose is for tests, you probably do not want to use this!
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
 */

class Cache_Internal extends Cache
{
	private $data;

	/**
	* Initialise a new internal cache.
	*/
	public function __construct($config)
	{
		$this->data = array();
	}

	protected function _set($key, $data, $ttl)
	{
		$this->data[$key] = array('expire' => $ttl > 0 ? time() + $ttl : 0, 'data' => $data);
	}

	protected function _get($key)
	{
		if (!array_key_exists($key, $this->data))
			return self::NOT_FOUND;

		$data = $this->data[$key];

		// Check if the data has expired
		if ($data['expire'] > 0 && $data['expire'] < time())
		{
			$this->delete($key);
			return self::NOT_FOUND;
		}

		return $data['data'];
	}

	public function delete($key)
	{
		unset($this->data[$key]);
	}

	public function clear()
	{
		unset($this->data);
		$this->data = array();
	}
}
