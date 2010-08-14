<?php

/**
 * The Serialize filter serializes data into string form.
 * This filter can be loaded by default as not all cache layers
 * support storing PHP objects.
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */

class Filter_Serialize implements Filter
{

	/**
	* Initialise a new Serialize filter.
	*/
	public function __construct($config)
	{

	}

	public function encode($data)
	{
		return serialize($data);
	}

	public function decode($data)
	{
		return unserialize($data);
	}
}
