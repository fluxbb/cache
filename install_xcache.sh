#! /bin/sh
wget http://xcache.lighttpd.net/pub/Releases/1.3.2/xcache-1.3.2.tar.gz
tar -zxf xcache-*.tar.gz
cd xcache-1.3.2
phpize
./configure --enable-xcache
make
sudo make install
echo zend_extension=~/.phpenv/versions/$(phpenv version-name)/lib/php/extensions/no-debug-non-zts-20090626/xcache.so > ~/.phpenv/versions/$(phpenv version-name)/etc/conf.d/xcache.ini
