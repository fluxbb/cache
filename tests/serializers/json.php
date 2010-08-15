<?php

define('PHPCACHE_ROOT', '../../');
require PHPCACHE_ROOT.'tests/serializers.php';

class JSONTest extends SerializersTest
{
	public function __construct()
	{
		parent::__construct('json');
	}
}
