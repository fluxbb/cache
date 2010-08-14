<?php

/**
 * The GZip filter compresses data using GZip.
 * http://uk2.php.net/manual/en/book.zlib.php
 * 
 * Copyright (C) 2010 Jamie Furness
 * License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */

class Filter_GZip implements Filter
{
	private $level;

	/**
	* Initialise a new GZip filter.
	* 
	* @param	level	The compression level to use, ranging from 0-9
	*/
	public function __construct($config)
	{
		$this->level = $config['level'];
	}

	public function encode($data)
	{
		return gzdeflate($data, $this->level);
	}

	public function decode($data)
	{
		return gzinflate($data);
	}
}
