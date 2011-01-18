# php-cache
php-cache is an API abstraction around various different cache stores available for PHP. Filters are supported to allow encoding of data during storage.
For cache stores that do not support data expiration (i.e. use of TTL) it is emulated.

License: [LGPL - GNU Lesser General Public License](http://www.gnu.org/licenses/lgpl.html)

## Supported cache stores
 * Flat files
 * [Alternative PHP Cache](http://uk2.php.net/manual/en/book.apc.php)
 * [Windows Cache](http://uk2.php.net/manual/en/book.wincache.php)
 * [XCache](http://xcache.lighttpd.net)
 * [Zend Cache Extension](http://files.zend.com/help/Zend-Platform/zend_cache_api.htm)
 * [eAccelerator](http://eaccelerator.net)
 * [Memcache](http://uk2.php.net/manual/en/book.memcache.php)
 * [Memcached](http://uk2.php.net/manual/en/book.memcached.php)
 * [Redis](http://github.com/owlient/phpredis)

## Available serializers
 * [PHP-serialize](http://uk2.php.net/manual/en/function.serialize.php)
 * [JSON](http://uk2.php.net/manual/en/book.json.php) * does not correctly serialize associative arrays or objects with protected/private attributes
 * [YAML](http://uk2.php.net/manual/en/book.yaml.php)
 * [XML](http://pear.php.net/package/XML_Serializer/)

## Available filters
### Compression
 * [BZip2](http://uk2.php.net/manual/en/book.bzip2.php)
 * [GZip](http://uk2.php.net/manual/en/book.zlib.php)
 * [LZF](http://uk2.php.net/manual/en/book.lzf.php)

### Encryption
 * [MCrypt](http://uk2.php.net/manual/en/book.mcrypt.php)

## API
	Cache::load($type, $args = array(), $serializer_type = false, $serializer_args = array());

	$cache->set($key, $data, $ttl = 0);
	$cache->get($key);
	$cache->delete($key);
	$cache->clear();

	$cache->inserts;
	$cache->hits;
	$cache->misses;

## Example usage
	// We want a file-based cache in the /tmp/php-cache/ dir - this will be created if possible. Obviously this path wont work on Windows!
	$cache = Cache::load('file', array('dir' => '/tmp/php-cache/'));

	// If we have the mcrypt extension lets encrypt the cache
	if (extension_loaded('mcrypt'))
	{
		echo 'Adding mcrypt filter.'."\n";
		$cache->add_filter('mcrypt', array('secret' => 'i like ponies'));
	}

	// Check if there is already a value cached
	$value = $cache->get('test');
	echo ($value === Cache::NOT_FOUND ? 'Value not found in cache.' : 'Value: '.$value)."\n";

	// Store a new unique ID in the cache
	$uniqid = uniqid();

	echo 'Storing: '.$uniqid."\n";
	$cache->set('test', $uniqid);

	// Check that the new value was stored correctly
	$value = $cache->get('test');
	echo ($value === Cache::NOT_FOUND ? 'Value not found in cache.' : 'Value: '.$value)."\n";

## Example output
	Adding mcrypt filter.
	Value not found in cache.
	Storing: 4d35ca30ab630
	Value: 4d35ca30ab630
