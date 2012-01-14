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
 * @copyright	Copyright (c) 2011 FluxBB (http://fluxbb.org)
 * @license		http://www.gnu.org/licenses/lgpl.html	GNU Lesser General Public License
 */

header('Content-type: text/plain');

define('PHPCACHE_ROOT', dirname(__FILE__).'/src/');
require PHPCACHE_ROOT.'cache.php';

$cache = fluxbb\cache\Cache::load('File', array('dir' => '/tmp/cache_test/', 'suffix' => '.php'), 'VarExport');

// Gzip all the cached data
$cache->addFilter('GZip', array('level' => 9));

// Store the current time in the cache
$cache->set('current_time', date('r'));

// Retreive the stored time from the cache
var_dump($cache->get('current_time'));

// Clear the cache (just for this example, obviously you don't want to clear it normally!)
$cache->clear();
