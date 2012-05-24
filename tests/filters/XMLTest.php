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

require_once dirname(__FILE__).'/../SerializerTestCase.php';
require_once PHPCACHE_ROOT.'filters/XML.php';

class XMLTest extends SerializerTestCase
{
	public function setUp()
	{
		if (!class_exists('XML_Serializer') || !class_exists('XML_Unserializer'))
		{
			$this->markTestSkipped(
				'The Pear::XML_Serializer library was not loaded.'
			);
		}

		$this->filter = new \fluxbb\cache\filters\XML(array());
	}
}
