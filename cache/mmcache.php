<?php

class Cache_MMCache extends Cache
{
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
