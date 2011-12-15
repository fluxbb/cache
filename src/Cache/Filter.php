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
	private $num_filters;
	private $filters;

	public function __construct()
	{
		$this->num_filters = 0;
		$this->filters = array();
	}

	public final function add_filter($type, $args = array())
	{
		if (!class_exists('Flux_Cache_Filter_'.$type))
			require PHPCACHE_ROOT.'Filter/'.$type.'.php';

		// Instantiate the filter
		$type = 'Flux_Cache_Filter_'.$type;
		$filter = new $type($args);

		$this->num_filters++;
		$this->filters[] = $filter;

		return $filter;
	}

	public function encode($data)
	{
		for ($i = 0;$i < $this->num_filters;$i++)
			$data = $this->filters[$i]->encode($data);

		return $data;
	}

	public function decode($data)
	{
		for ($i = $this->num_filters - 1;$i >= 0;$i--)
			$data = $this->filters[$i]->decode($data);

		return $data;
	}
}
