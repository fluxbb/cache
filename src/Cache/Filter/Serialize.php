<?php

/**
 * The Serialize filter serializes data into string form.
 * This filter can be loaded by default as not all cache layers
 * support storing PHP objects.
 *
 * Copyright (C) 2011 FluxBB (http://fluxbb.org)
 * License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
 */

class Flux_Cache_Filter_Serialize implements Flux_Cache_Filter, Flux_Cache_Serializer
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
