<?php

/**
 * The Serialize filter serializes data into string form.
 * This filter can be loaded by default as not all cache layers
 * support storing PHP objects.
 *
 * Copyright (C) 2011 FluxBB (http://fluxbb.org)
 * License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
 */

class SerializeFilter implements Filter, Serializer
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
