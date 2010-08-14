<?php

/**
 * The MCrypt filter encrypts data using the given cipher and secret key.
 * http://uk2.php.net/manual/en/book.mcrypt.php
 * 
 * Copyright (C) 2010 Jamie Furness (http://www.jamierf.co.uk)
 * License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */

class Filter_MCrypt implements Filter
{
	private $key;
	private $cipher;
	private $mode;
	private $iv;

	/**
	* Initialise a new MCrypt filter.
	* 
	* @param	secret	The secret key to encrypt/decrypt data with
	* @param	cipher	The cipher to use, defaults to MCRYPT_RIJNDAEL_128
	* @param	mode	The block cipher mode to use, defaults to MCRYPT_MODE_ECB
	*/
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
