<?php

/**
* Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
* License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
*/

require 'filter.php';

abstract class Cache extends FilterUser
{
	const NOT_FOUND = 'Cache::NOT_FOUND';

	const DEFAULT_SERIALIZER = 'serialize';

	public static function load($type, $args = array(), $serializer = false)
	{
		@include_once 'cache/'.$type.'.php';
		if (!class_exists('Cache_'.$type))
			throw new Exception('Unknown cache: '.$type);

		if ($serializer === false)
			$serializer = self::DEFAULT_SERIALIZER;

		// Instantiate the correct class and confirm it extends us
		$cache = call_user_func(array(new ReflectionClass('Cache_'.$type), 'newInstance'), $args);
		if (!is_subclass_of($cache, 'Cache'))
			throw new Exception('Does not conform to the cache interface: '.$type);

		// Add a serialize filter by default as not all caches can handle storing PHP objects
		$cache->add_filter($serializer);

		return $cache;
	}

	public $hits = 0;
	public $misses = 0;

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
		{
			$this->misses++;
			return self::NOT_FOUND;
		}

		$data = $this->decode($data);

		$this->hits++;
		return $data;
	}

	protected abstract function _get($key);

	public abstract function delete($key);
	public abstract function clear();
}
