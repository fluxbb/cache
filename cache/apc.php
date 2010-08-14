<?php

class Cache_APC extends Cache
{
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
