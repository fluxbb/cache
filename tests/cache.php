<?php
/**
 * FluxBB
 *
 * LICENSE
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * @category	FluxBB
 * @package		Cache
 * @subpackage	Tests
 * @copyright	Copyright (c) 2011 FluxBB (http://fluxbb.org)
 * @license		http://www.gnu.org/licenses/lgpl.html	GNU Lesser General Public License
 */

namespace fluxbb\cache\tests;

define('PHPCACHE_ROOT', realpath(dirname(__FILE__).'/../').'/src/');
require PHPCACHE_ROOT.'cache.php';

abstract class CacheTest extends \PHPUnit_Framework_TestCase
{
	protected static $cache;

	/**
	 * @dataProvider provider
	 */
	public function testGetSet($key, $value)
	{
		self::$cache->set($key, $value);

		$result = self::$cache->get($key);
		$this->assertEquals($result, $value);
	}
	
	public function testGetFalse()
	{
		self::$cache->set('testfalse', false);
		
		$result = self::$cache->get('testfalse');
		$this->assertNotEquals(\fluxbb\cache\Cache::NOT_FOUND, $result);
		$this->assertEquals(false, $result);
	}

	public function testDelete()
	{
		$key = 'test';

		self::$cache->set($key, time());
		self::$cache->delete($key);

		$result = self::$cache->get($key);
		$this->assertEquals($result, \fluxbb\cache\Cache::NOT_FOUND);
	}

	public function provider()
	{
		return array(
			array('int', time()),
			array('string', 'hello world'),
			array('bool', true),
			array('null', null),
			array('array', array(0 => 'zero', 1 => 'one', 7 => 'seven')),
			array('object', new \DOMComment('hello world')),
		);
	}
}
