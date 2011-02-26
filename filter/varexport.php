<?php

/**
 * The var_export filter serializes data into PHP code.
 * This filter can be loaded by default as not all cache layers
 * support storing PHP objects.
 * 
 * Copyright (C) 2011 FluxBB (http://fluxbb.org)
 * License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
 */

class Filter_VarExport implements Filter, Serializer
{

	/**
	* Initialise a new VarExport filter.
	*/
	public function __construct($config)
	{

	}

	public function encode($data)
	{
		return 'return '.var_export($data, true).';';
	}

	public function decode($data)
	{
		return eval($data);
	}
}
