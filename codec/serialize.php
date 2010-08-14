<?php

class Codec_Serialize implements Codec
{
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
