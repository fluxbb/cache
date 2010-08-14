<?php

class Cache_XCache extends Cache
{
	public function __construct($config)
	{

	}

	protected function _set($key, $data)
	{
		if (xcache_set($key, $data) === false)
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
}
