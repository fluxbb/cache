<?php

class Cache_Memcached extends Cache
{
	const DEFAULT_HOST = 'localhost';
	const DEFAULT_PORT = 11211;

	private $memcached;

	public function __construct($config)
	{
		$host = isset($config['host']) ? $config['host'] : self::DEFAULT_HOST;
		$port = isset($config['port']) ? $config['port'] : self::DEFAULT_PORT;

		$this->memcached = new Memcached();
		$this->memcached->addServer($host, $port);
	}

	protected function _set($key, $data)
	{
		if ($this->memcached->set($key, $data) === false)
			throw new Exception('Unable to write memcached cache: '.$key);
	}

	protected function _get($key)
	{
		$data = $this->memcached->get($key);
		if ($data === false)
			return self::NOT_FOUND;

		return $data;
	}

	public function delete($key)
	{
		$this->memcached->delete($key);
	}
}
