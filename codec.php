<?php

interface Codec
{
	public function encode($data);
	public function decode($data);
}

class CodecUser
{
	private $num_codecs;
	private $codecs;

	public function __construct()
	{
		$this->num_codecs = 0;
		$this->codecs = array();
	}

	public function add_codec($codec, $args = array())
	{
		if (!file_exists('codec/'.$codec.'.php'))
			throw new Exception('Unknown codec: '.$codec);

		require_once 'codec/'.$codec.'.php';

		$this->num_codecs++;
		$this->codecs[] = call_user_func(array(new ReflectionClass('Codec_'.$codec), 'newInstance'), $args);
	}

	protected function encode($data)
	{
		for ($i = 0;$i < $this->num_codecs;$i++)
			$data = $this->codecs[$i]->encode($data);

		return $data;
	}

	protected function decode($data)
	{
		for ($i = $this->num_codecs - 1;$i >= 0;$i--)
			$data = $this->codecs[$i]->decode($data);

		return $data;
	}
}
