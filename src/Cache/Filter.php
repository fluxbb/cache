<?php

/**
* Copyright (C) 2011 FluxBB (http://fluxbb.org)
* License: LGPL - GNU Lesser General Public License (http://www.gnu.org/licenses/lgpl.html)
*/

interface Flux_Cache_Serializer
{

}

interface Flux_Cache_Filter
{
	public function encode($data);
	public function decode($data);
}

class Flux_Cache_FilterUser
{
	private $numFilters;
	private $filters;

	public function __construct()
	{
		$this->numFilters = 0;
		$this->filters = array();
	}

	public final function addFilter($type, $args = array())
	{
		if (!class_exists('Flux_Cache_Filter_'.$type))
		{
			if (!file_exists(PHPCACHE_ROOT.'Cache/Filter/'.$type.'.php'))
				throw new Exception('Cache filter "'.$type.'" does not exist.');

			require PHPCACHE_ROOT.'Cache/Filter/'.$type.'.php';
		}

		// Instantiate the filter
		$type = 'Flux_Cache_Filter_'.$type;
		$filter = new $type($args);

		$this->numFilters++;
		$this->filters[] = $filter;

		return $filter;
	}

	public function encode($data)
	{
		for ($i = 0; $i < $this->numFilters; $i++)
			$data = $this->filters[$i]->encode($data);

		return $data;
	}

	public function decode($data)
	{
		for ($i = $this->numFilters - 1; $i >= 0; $i--)
			$data = $this->filters[$i]->decode($data);

		return $data;
	}
}
