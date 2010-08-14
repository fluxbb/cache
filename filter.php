<?php

/**
* Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
* License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
*/

interface Filter
{
	public function encode($data);
	public function decode($data);
}

class FilterUser
{
	private $num_filters;
	private $filters;

	public function __construct()
	{
		$this->num_filters = 0;
		$this->filters = array();
	}

	public function add_filter($type, $args = array())
	{
		@include_once 'filter/'.$type.'.php';
		if (!class_exists('Filter_'.$type))
			throw new Exception('Unknown filter: '.$type);

		// Instantiate the correct class and confirm it implements the Filter interface
		$filter = call_user_func(array(new ReflectionClass('Filter_'.$type), 'newInstance'), $args);
		if (!($filter instanceof Filter))
			throw new Exception('Does not conform to the filter interface: '.$type);

		$this->num_filters++;
		$this->filters[] = $filter;
	}

	protected function encode($data)
	{
		for ($i = 0;$i < $this->num_filters;$i++)
			$data = $this->filters[$i]->encode($data);

		return $data;
	}

	protected function decode($data)
	{
		for ($i = $this->num_filters - 1;$i >= 0;$i--)
			$data = $this->filters[$i]->decode($data);

		return $data;
	}
}
