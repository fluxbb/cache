<?php

define('PHPCACHE_ROOT', dirname(__FILE__).'/../../cache/');
require PHPCACHE_ROOT.'../tests/filters.php';

class BZip2Test extends FilterTest
{
	public function __construct()
	{
		parent::__construct('bzip2', array('level' => 5));
	}
}
