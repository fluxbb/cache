<?php

define('PHPCACHE_ROOT', '../../');
require PHPCACHE_ROOT.'tests/serializers.php';

class YAMLTest extends SerializersTest
{
	public function __construct()
	{
		parent::__construct('yaml');
	}
}
