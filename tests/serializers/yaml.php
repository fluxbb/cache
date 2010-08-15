<?php

define('PHPCACHE_ROOT', dirname(__FILE__).'/../../cache/');
require PHPCACHE_ROOT.'../tests/serializers.php';

class YAMLTest extends SerializersTest
{
	public function __construct()
	{
		parent::__construct('yaml');
	}
}
