<?php

require 'codec.php';

abstract class Cache extends CodecUser
{
	const NOT_FOUND = 'Cache::NOT_FOUND';

	public static function load($type, $args = array())
	{
		if (!file_exists('cache/'.$type.'.php'))
			throw new Exception('No such cache layer: '.$type);

		require_once 'cache/'.$type.'.php';

		$cache = call_user_func(array(new ReflectionClass('Cache_'.$type), 'newInstance'), $args);
		$cache->add_codec('serialize');

		return $cache;
	}

	public function __construct($config)
	{
	
	}

	public function set($key, $data)
	{
		$data = $this->encode($data);
		$this->_set($key, $data);
	}

	protected abstract function _set($key, $data);

	public function get($key)
	{
		$data = $this->_get($key);
		if ($data === self::NOT_FOUND)
			return self::NOT_FOUND;

		$data = $this->decode($data);

		return $data;
	}

	protected abstract function _get($key);

	public abstract function delete($key);
}
