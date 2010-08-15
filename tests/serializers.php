<?php

require PHPCACHE_ROOT.'filter.php';

class TestHelper
{
	// Public attributes
	public $string;
	public $int;
	// Protected attributes
	protected $float;
	protected $boolean;
	// Private attributes
	private $array;
	private $map;
	// PHP4 style attributes (public)
	var $null;

	public function __construct()
	{
		$this->string = 'hello';
		$this->int = time();
		$this->float = 1.2;
		$this->boolean = true;
		$this->array = array('a', 'b', 'c');
		$this->map = array('a' => 1, 'b' => 2, 'c' => 3);
		$this->null = null;
	}
}

abstract class SerializersTest extends PHPUnit_Framework_TestCase
{
	protected $serializer;

	public function __construct($serializer)
	{
		$this->serializer = $serializer;
		parent::__construct();
	}

	public function testString()
	{
		$decoded = $this->doTest('hello');
		$this->assertTrue(is_string($decoded));
	}

	public function testInt()
	{
		$decoded = $this->doTest(time());
		$this->assertTrue(is_int($decoded));
	}

	public function testFloat()
	{
		$decoded = $this->doTest(1.2);
		$this->assertTrue(is_float($decoded));
	}

	public function testBoolean()
	{
		$decoded = $this->doTest(true);
		$this->assertTrue(is_bool($decoded));
	}

	public function testArray()
	{
		$decoded = $this->doTest(array('a', 'b', 'c'));
		$this->assertTrue(is_array($decoded));
	}

	public function testMap()
	{
		$decoded = $this->doTest(array('a' => 1, 'b' => 2, 'c' => 3));
		$this->assertTrue(is_array($decoded));
	}

	public function testObject()
	{
		$decoded = $this->doTest(new TestHelper());
		$this->assertTrue(is_a($decoded, 'TestHelper'));
	}

	public function testNull()
	{
		$decoded = $this->doTest(null);
		$this->assertTrue(is_null($decoded));
	}

	private function doTest($data)
	{
		$user = new FilterUser();
		$user->add_filter($this->serializer);

		$encoded = $user->encode($data);
		$this->assertTrue(is_string($encoded));

		$decoded = $user->decode($encoded);
		$this->assertEquals($data, $decoded);

		return $decoded;
	}
}
