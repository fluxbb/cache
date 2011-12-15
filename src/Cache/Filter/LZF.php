<?php

/**
 * The LZF filter compresses data using LZF.
 * http://uk2.php.net/manual/en/book.lzf.php
 *
 * Copyright (C) 2011 FluxBB (http://fluxbb.org)
 * License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
 */

class Flux_Cache_Filter_LZF implements Flux_Cache_Filter
{
	private $level;

	/**
	* Initialise a new LZF filter.
	*/
	public function __construct($config)
	{
		if (!extension_loaded('lzf'))
			throw new Exception('The ZLF filter requires the ZLF extension.');
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
