<?php

/**
 * The Spyc filter serializes data into YAML string form.
 * This filter can be loaded by default as not all cache layers
 * support storing PHP objects.
 * http://code.google.com/p/spyc/
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
 */

class Filter_Spyc implements Filter, Serializer
{

	/**
	* Initialise a new Spyc filter.
	*/
	public function __construct($config)
	{
		require_once PHPCACHE_ROOT.'lib/spyc.php';
	}

	public function encode($data)
	{
		return Spyc::YAMLDump($data);
	}

	public function decode($data)
	{
		return Spyc::YAMLLoad($data);
	}
}
