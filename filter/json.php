<?php

class Filter_JSON implements Filter
{
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
