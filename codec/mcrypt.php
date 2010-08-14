<?php

class Codec_MCrypt
{
	private $key;
	private $cipher;
	private $mode;
	private $iv;

	public function __construct($config)
	{
		$this->key = md5($config['secret']);
		$this->cipher = isset($config['cipher']) ? $config['cipher'] : MCRYPT_RIJNDAEL_128;
		$this->mode = isset($config['mode']) ? $config['mode'] : MCRYPT_MODE_ECB;

		$this->iv = mcrypt_create_iv(mcrypt_get_iv_size($this->cipher, $this->mode), MCRYPT_RAND);
	}

	public function encode($data)
	{
		$data = mcrypt_encrypt($this->cipher, $this->key, $data, $this->mode, $this->iv);
		return base64_encode($data);
	}

	public function decode($data)
	{
		$data = base64_decode($data);
		return mcrypt_decrypt($this->cipher, $this->key, $data, $this->mode, $this->iv);
	}
}
