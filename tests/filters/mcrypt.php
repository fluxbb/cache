<?php

define('PHPCACHE_ROOT', dirname(__FILE__).'/../../cache/');
require PHPCACHE_ROOT.'../tests/filters.php';

class MCryptTest extends FilterTest
{
	public function __construct()
	{
		parent::__construct('mcrypt', array('secret' => 'i like ponies'));
	}
}
