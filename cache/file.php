<?php

/**
 * The File cache stores data using regular files.
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
 */

class Cache_File extends Cache
{
	const SUFFIX = '.cache';

	private $dir;

	/**
	* Initialise a new File cache.
	* 
	* @param	dir	The directory in which to store cache files. Must be
					writable by PHP and will be created if required.
	*/
	public function __construct($config)
	{
		$this->dir = $config['dir'];
		if ((!is_dir($this->dir) && !mkdir($this->dir, 0777, true)) || !is_writable($this->dir))
			throw new Exception('Unable to write to cache dir: '.$this->dir);
	}

	private function key($key)
	{
		return sha1($key);
	}

	// Since we are emulating the TTL we need to override set()
	public function set($key, $data, $ttl = 0)
	{
		// Since files don't support TTL we need to emulate it
		$data = array('expire' => $ttl > 0 ? time() + $ttl : 0, 'data' => $data);

		parent::set($key, $data, $ttl);
	}

	protected function _set($key, $data, $ttl)
	{
		if (@file_put_contents($this->dir.$this->key($key).self::SUFFIX, $data) === false)
			throw new Exception('Unable to write file cache: '.$key);
	}

	// Since we are emulating the TTL we need to override get()
	public function get($key)
	{
		$data = parent::get($key);
		if ($data === self::NOT_FOUND)
			return self::NOT_FOUND;

		// Check if the data has expired
		if ($data['expire'] > 0 && $data['expire'] < time())
		{
			$this->delete($key);

			// Correct the hit/miss counts
			$this->hits--;
			$this->misses++;

			return self::NOT_FOUND;
		}

		return $data['data'];
	}

	protected function _get($key)
	{
		$data = @file_get_contents($this->dir.$this->key($key).self::SUFFIX);
		if ($data === false)
			return self::NOT_FOUND;

		return $data;
	}

	protected function _delete($key)
	{
		@unlink($this->dir.$this->key($key).self::SUFFIX);

		// Incase we are using APC with apc.stat=0
		if (function_exists('apc_delete_file'))
			@apc_delete_file($this->dir.$this->key($key).self::SUFFIX);
	}

	public function clear()
	{
		$files = glob($this->dir.'*'.self::SUFFIX);
		foreach ($files as $file)
			@unlink($file);
	}
}
