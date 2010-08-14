<?php

/**
* The BZip2 filter compresses data using BZip2. BZip2 can reach a higher
* compression ratio than GZip but is considerabily slower.
* http://uk2.php.net/manual/en/book.bzip2.php
* 
* Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
* License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
*/

class Filter_BZip2 implements Filter
{
	private $level;

	/**
	* Initialise a new BZip2 filter.
	* 
	* @param	level	The compression level to use, ranging from 0-9
	*/
	public function __construct($config)
	{
		if (!extension_loaded('bzip2'))
			throw new Exception('The BZip2 filter requires the BZip2 extension.');

		$this->level = $config['level'];
	}

	public function encode($data)
	{
		return bzcompress($data, $this->level);
	}

	public function decode($data)
	{
		return bzdecompress($data);
	}
}
