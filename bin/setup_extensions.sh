#! /bin/sh

# Enable Memcache
#echo "extension = memcache.so" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini

# Install Memcached
#echo "extension = memcached.so" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini

# Install APC
echo "extension = apc.so" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini
echo "apc.enabled = 1" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini
echo "apc.enable_cli = 1" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini

# Install Redis bindings
#echo "extension = redis.so" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini

# Install YAML
pecl install yaml

# Install LZF
pecl install lzf

phpenv rehash