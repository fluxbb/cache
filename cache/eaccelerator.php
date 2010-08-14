<?php

class Cache_eAccelerator extends Cache
{
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
