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

		// Confirm the chosen class extends us
		$class = new ReflectionClass('Cache_'.$type);
		if ($class->isSubclassOf('Cache') === false)
			throw new Exception('Does not conform to the cache interface: '.$type);

		// Instantiate the cache
		$cache = $class->newInstance($args);

		// If we have a prefix defined, set it
		if (isset($args['prefix']))
			$cache->prefix = $args['prefix'];

		// Add a serialize filter by default as not all caches can handle storing PHP objects
		$serializer = $cache->add_filter($serializer_type, $serializer_args);
		if (!($serializer instanceof Serializer))
			throw new Exception('Attempted to add serializer that does not implement the Serializer interface: '.$serializer_type);

		return $cache;
	}

	public $inserts = 0;
	public $hits = 0;
	public $misses = 0;
	protected $prefix = '';

	public function set($key, $data, $ttl = 0)
	{
		$data = $this->encode($data);
		$this->_set($this->prefix.$key, $data, $ttl);
		$this->inserts++;
	}

	protected abstract function _set($key, $data, $ttl);

	public function get($key)
	{
		$data = $this->_get($this->prefix.$key);
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

	public function delete($key)
	{
		$this->_delete($this->prefix.$key);
	}

	protected abstract function _delete($key);

	public abstract function clear();
}
