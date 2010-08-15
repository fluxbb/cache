<?php

/**
* Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
* License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
*/

if (!defined('PHPCACHE_ROOT'))
	define('PHPCACHE_ROOT', dirname(__FILE__).'/');

require PHPCACHE_ROOT.'filter.php';

abstract class Cache extends FilterUser
{
	const NOT_FOUND = 'Cache::NOT_FOUND';
	const DEFAULT_SERIALIZER = 'serialize';

	public static function load($type, $args = array(), $serializer_type = false, $serializer_args = array())
	{
		@include_once PHPCACHE_ROOT.'cache/'.$type.'.php';
		if (!class_exists('Cache_'.$type))
			throw new Exception('Unknown cache: '.$type);

		if ($serializer_type === false)
		{
			$serializer_type = self::DEFAULT_SERIALIZER;
			$serializer_args = array();
		}

		// Instantiate the correct class and confirm it extends us
		$cache = call_user_func(array(new ReflectionClass('Cache_'.$type), 'newInstance'), $args);
		if (!is_subclass_of($cache, 'Cache'))
			throw new Exception('Does not conform to the cache interface: '.$type);

		// Add a serialize filter by default as not all caches can handle storing PHP objects
		$serializer = $cache->add_filter($serializer_type, $serializer_args);
		if (!($serializer instanceof Serializer))
			throw new Exception('Attempted to add serializer that does not implement the Serializer interface: '.$serializer_type);

		return $cache;
	}

	public $inserts = 0;
	public $hits = 0;
	public $misses = 0;

	public function set($key, $data, $ttl = 0)
	{
		$data = $this->encode($data);
		$this->_set($key, $data, $ttl);
		$this->inserts++;
	}

	protected abstract function _set($key, $data, $ttl);

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
