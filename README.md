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
 * [JSON](http://uk2.php.net/manual/en/book.json.php)
 * [YAML](http://uk2.php.net/manual/en/book.yaml.php)
 * [Spyc](http://code.google.com/p/spyc/) (YAML)

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