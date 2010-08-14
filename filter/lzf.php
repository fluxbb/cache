<?php

/**
 * The LZF filter compresses data using LZF.
 * http://uk2.php.net/manual/en/book.lzf.php
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */

class Filter_LZF implements Filter
{
	private $level;

	/**
	* Initialise a new LZF filter.
	*/
	public function __construct($config)
	{

	}

	public function encode($data)
	{
		return lzf_compress($data);
	}

	public function decode($data)
	{
		return lzf_decompress($data);
	}
}
