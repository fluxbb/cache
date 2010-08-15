<?php

define('PHPCACHE_ROOT', dirname(__FILE__).'/../../cache/');
require PHPCACHE_ROOT.'../tests/filter.php';

class LZFTest extends FilterTest
{
	public function __construct()
	{
		parent::__construct('lzf');
	}
}
