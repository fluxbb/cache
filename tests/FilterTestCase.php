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

if (!defined('PHPCACHE_ROOT'))
	define('PHPCACHE_ROOT', realpath(dirname(__FILE__).'/../').'/src/');

require_once PHPCACHE_ROOT.'filter.php';

abstract class FilterTestCase extends \PHPUnit_Framework_TestCase
{
	/**
	 * The filter used for testing.
	 *
	 * This should better be set by concrete tests.
	 *
	 * @var fluxbb\cache\Filter
	 */
	protected $filter;


	/**
	 * @dataProvider provider
	 */
	public function testDecodedEqualsOriginalString($value)
	{
		$encoded = $this->filter->encode($value);
		$decoded = $this->filter->decode($encoded);

		$this->assertEquals($value, $decoded);
	}

	public function provider()
	{
		return array(
			array(1234),
			array('hello world'),
			array(true),
			array(null),
			array(array(0 => 'zero', 1 => 'one', 7 => 'seven')),
			//array(new \DOMComment('hello world')), // TODO: Is there any way to handle objects, too?
		);
	}
}
