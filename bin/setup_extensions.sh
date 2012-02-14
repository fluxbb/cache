#! /bin/sh

# Install Memcache
wget http://pecl.php.net/get/memcache-2.2.6.tgz
tar -xzf memcache-2.2.6.tgz
sh -c "cd memcache-2.2.6 && phpize && ./configure --enable-memcache && make && sudo make install"
echo "extension=memcache.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`

# Install Memcached
wget http://pecl.php.net/get/memcached-1.0.2.tgz
tar -xzf memcached-1.0.2.tgz
sh -c "cd memcached-1.0.2 && phpize && ./configure && make && sudo make install"
echo "extension=memcached.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`
