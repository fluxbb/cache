<?php

/**
 * The File cache stores data using regular files.
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */

class Cache_File extends Cache
{
	const EMULATE_TTL = true;

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

	protected function _set($key, $data, $ttl)
	{
		if (@file_put_contents($this->dir.$this->key($key).self::SUFFIX, $data) === false)
			throw new Exception('Unable to write file cache: '.$key);
	}

	protected function _get($key)
	{
		$data = @file_get_contents($this->dir.$this->key($key).self::SUFFIX);
		if ($data === false)
			return self::NOT_FOUND;

		return $data;
	}

	public function delete($key)
	{
		@unlink($this->dir.$this->key($key).self::SUFFIX);
	}

	public function clear()
	{
		$files = glob($this->dir.'*'.self::SUFFIX);
		foreach ($files as $file)
			@unlink($file);
	}
}
