<?php

define('PHPCACHE_ROOT', dirname(__FILE__).'/../../cache/');
require PHPCACHE_ROOT.'../tests/serializer.php';

class JSONTest extends SerializersTest
{
	public function __construct()
	{
		parent::__construct('json');
	}
}
