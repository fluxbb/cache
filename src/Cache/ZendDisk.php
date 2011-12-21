<?php
/**
 * FluxBB
 *
 * LICENSE
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * @category	FluxBB
 * @package		Flux_Cache
 * @copyright	Copyright (c) 2011 FluxBB (http://fluxbb.org)
 * @license		http://www.gnu.org/licenses/lgpl.html	GNU Lesser General Public License
 */

/**
 * The Zend Disk cache stores data using Zend disk.
 * http://files.zend.com/help/Zend-Platform/zend_cache_api.htm
 *
 * Copyright (C) 2011 FluxBB (http://fluxbb.org)
 * License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
 */

class Flux_Cache_ZendDisk extends Flux_Cache
{
	const NAMESPACE = 'php-cache';

	/**
	* Initialise a new Zend Disk cache.
	*/
	public function __construct($config)
	{
		if (!extension_loaded('zendcache'))
			throw new Exception('The Zend Disk cache requires the ZendCache extension.');
	}

	private function key($key)
	{
		return self::NAMESPACE.'::'.$key;
	}

	protected function _set($key, $data, $ttl)
	{
		if (zend_disk_cache_store($this->key($key), $data, $ttl) === false)
			throw new Exception('Unable to write Zend Disk cache: '.$key);
	}

	protected function _get($key)
	{
		$data = zend_disk_cache_fetch($this->key($key));
		if ($data === null)
			return self::NOT_FOUND;

		return $data;
	}

	protected function _delete($key)
	{
		zend_disk_cache_delete($this->key($key));
	}

	public function clear()
	{
		zend_disk_cache_clear(self::NAMESPACE);
	}
}
