<?php

/**
* The BZip2 filter compresses data using BZip2. BZip2 can reach a higher
* compression ratio than GZip but is considerabily slower.
* http://uk2.php.net/manual/en/book.bzip2.php
* 
* Copyright (C) 2011 FluxBB (http://fluxbb.org)
* License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
*/

class Filter_BZip2 implements Filter
{
	const DEFAULT_LEVEL = 4;

	private $level;

	/**
	* Initialise a new BZip2 filter.
	* 
	* @param	level	The compression level to use, ranging from 1-9. Defaults to 4
	*/
	public function __construct($config)
	{
		if (!extension_loaded('bz2'))
			throw new Exception('The BZip2 filter requires the bz2 extension.');

		$this->level = isset($config['level']) ? $config['level'] : self::DEFAULT_LEVEL;
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
