<?php

/**
 * The Zend SHM cache stores data using Zend shared memory.
 * http://files.zend.com/help/Zend-Platform/zend_cache_api.htm
 *
 * Copyright (C) 2011 FluxBB (http://fluxbb.org)
 * License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
 */

class Zend_SHMCache extends Cache
{
	const NAMESPACE = 'php-cache';

	/**
	* Initialise a new Zend SHM cache.
	*/
	public function __construct($config)
	{
		if (!extension_loaded('zendcache'))
			throw new Exception('The Zend SHM cache requires the ZendCache extension.');
	}

	private function key($key)
	{
		return self::NAMESPACE.'::'.$key;
	}

	protected function _set($key, $data, $ttl)
	{
		if (zend_shm_cache_store($this->key($key), $data, $ttl) === false)
			throw new Exception('Unable to write Zend SHM cache: '.$key);
	}

	protected function _get($key)
	{
		$data = zend_shm_cache_fetch($this->key($key));
		if ($data === null)
			return self::NOT_FOUND;

		return $data;
	}

	protected function _delete($key)
	{
		zend_shm_cache_delete($this->key($key));
	}

	public function clear()
	{
		zend_shm_cache_clear(self::NAMESPACE);
	}
}
