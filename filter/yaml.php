<?php

/**
 * The YAML filter serializes data into YAML string form.
 * This filter can be loaded by default as not all cache layers
 * support storing PHP objects.
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */

class Filter_YAML implements Filter
{

	/**
	* Initialise a new YAML filter.
	*/
	public function __construct($config)
	{
		if (!extension_loaded('yaml'))
			throw new Exception('The YAML filter requires the YAML extension.');
	}

	public function encode($data)
	{
		return yaml_emit($data, YAML_UTF8_ENCODING, YAML_LN_BREAK);
	}

	public function decode($data)
	{
		return yaml_parse($data);
	}
}
