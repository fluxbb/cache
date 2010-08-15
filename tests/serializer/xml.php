<?php

define('PHPCACHE_ROOT', dirname(__FILE__).'/../../cache/');
require PHPCACHE_ROOT.'../tests/serializer.php';

class XMLTest extends SerializersTest
{
	public function __construct()
	{
		parent::__construct('xml');
	}
}
