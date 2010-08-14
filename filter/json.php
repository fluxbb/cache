<?php

/**
 * The JSON filter serializes data into json string form.
 * This filter can be loaded by default as not all cache layers
 * support storing PHP objects.
 * 
 * Copyright (C) 2010 Frank Smit (http://61924.nl)
 * License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */

class Filter_JSON implements Filter, Serializer
{

	/**
	* Initialise a new JSON filter.
	*/
	public function __construct($config)
	{

	}

	public function encode($data)
	{
		return json_encode($data);
	}

	public function decode($data)
	{
		return json_decode($data);
	}
}
