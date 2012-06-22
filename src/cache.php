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
 * @package		Cache
 * @copyright	Copyright (c) 2011 FluxBB (http://fluxbb.org)
 * @license		http://www.gnu.org/licenses/lgpl.html	GNU Lesser General Public License
 */

namespace fluxbb\cache;

if (!defined('PHPCACHE_ROOT'))
	define('PHPCACHE_ROOT', dirname(__FILE__).'/');

require_once PHPCACHE_ROOT.'filter.php';

/**
 * A base class for all cache adapters.
 *
 * @abstract
 */
abstract class Cache extends FilterUser
{
	const NOT_FOUND = 'Cache::NOT_FOUND';
	const DEFAULT_SERIALIZER = 'Serialize';

	/**
	 * Create a cache adapter of the given type with the given settings.
	 *
	 * @param  string  $type           The type of cache adapter to create
	 * @param  array   $args           Options to be passed to the cache adapter
	 * @param  boolean $serializerType The type of serializer to be added to the cache adapter
	 * @param  array   $serializerArgs Options to be passed to the serializer
	 * @return fluxbb\cache\Cache      The adapter instance
	 */
	public static final function load($type, $args = array(), $serializerType = false, $serializerArgs = array())
	{
		if (!class_exists('\\fluxbb\\cache\\modules\\'.$type, false))
		{
			if (!file_exists(PHPCACHE_ROOT.'modules/'.$type.'.php'))
			{
				throw new Exception('Cache type "'.$type.'" does not exist.');
			}

			require PHPCACHE_ROOT.'modules/'.$type.'.php';
		}

		if ($serializerType === false)
		{
			$serializerType = self::DEFAULT_SERIALIZER;
			$serializerArgs = array();
		}

		// Instantiate the cache
		$type = '\\fluxbb\\cache\\modules\\'.$type;
		$cache = new $type($args);

		// If we have a prefix defined, set it
		if (isset($args['prefix']))
		{
			$cache->prefix = $args['prefix'];
		}

		// Add a serialize filter by default as not all caches can handle storing PHP objects
		$cache->addFilter($serializerType, $serializerArgs);

		return $cache;
	}

	/**
	 * The number of elements that were added to the cache.
	 *
	 * @var integer
	 */
	public $inserts = 0;

	/**
	 * The number of elements that were successfully retrieved from cache.
	 *
	 * @var integer
	 */
	public $hits = 0;

	/**
	 * The number of failed attempts to retrieve an element from cache.
	 *
	 * @var integer
	 */
	public $misses = 0;

	/**
	 * A prefix to be prepended to the key of the cache element.
	 *
	 * @var string
	 */
	protected $prefix = '';

	/**
	 * Add an element to the cache store.
	 *
	 * @param string  $key  The name under which the element will be stored
	 * @param mixed   $data The element to be stored
	 * @param integer $ttl  The time (in seconds) for this element to be stored
	 */
	public function set($key, $data, $ttl = 0)
	{
		$data = $this->encode($data);
		$this->_set($this->prefix.$key, $data, $ttl);
		$this->inserts++;
	}

	/**
	 * Template method for actually adding an element to the cache store.
	 *
	 * This method should be overwritten by subclasses. It needs to store the
	 * given element in the cache backend and not surpass the given "time to live".
	 *
	 * @param string  $key  The name under which the element will be stored
	 * @param mixed   $data The element to be stored
	 * @param integer $ttl  The time (in seconds) for this element to be stored
	 */
	protected abstract function _set($key, $data, $ttl);

	/**
	 * Retrieve an element from cache.
	 *
	 * This function returns Cache::NOT_FOUND if the element could not be found in cache.
	 *
	 * @param  string $key The name of the element to be retrieved
	 * @return mixed       The requested element's value
	 */
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

	/**
	 * Template method for actually retrieving an element from cache.
	 *
	 * This method should be overwritten by subclasses. It needs to fetch the
	 * requested element from the cache backend.
	 *
	 * @param  string $key The name of the element to be retrieved
	 * @return mixed       The requested element's value
	 */
	protected abstract function _get($key);

	/**
	 * Retrieve an element from cache, or set it if it isn't stored yet.
	 *
	 * @param  string   $key     The name of the element to be retrieved
	 * @param  callback $default A callback generating a value to be stored if the element could not be found in cache
	 * @return mixed             The requested element's value
	 */
	public function remember($key, $default)
	{
		$value = $this->get($key);
		if ($value === self::NOT_FOUND)
		{
			$value = $default();
			$this->set($key, $value);
		}

		return $value;
	}

	/**
	 * Delete an element from the cache store.
	 *
	 * @param  string $key The name of the element to be deleted
	 * @return void
	 */
	public function delete($key)
	{
		$this->_delete($this->prefix.$key);
	}

	/**
	 * Template method for actually deleting an element from the cache store.
	 *
	 * This method should be overwritten by subclasses. It needs to delete the
	 * given element from the cacke backend.
	 *
	 * @param  string $key The name of the element to be deleted
	 * @return void
	 */
	protected abstract function _delete($key);

	/**
	 * Clear the cache.
	 *
	 * This method needs to be overwritten by subclasses.
	 *
	 * @return void
	 */
	public abstract function clear();
}

class Exception extends \Exception
{
	public function __construct($msg)
	{
		parent::__construct($msg);
	}
}
