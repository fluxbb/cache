#! /bin/sh
wget http://xcache.lighttpd.net/pub/Releases/1.3.2/xcache-1.3.2.tar.gz
tar -zxf xcache-*.tar.gz
cd xcache-1.3.2
phpize
./configure --enable-xcache
make
sudo make install
echo zend_extension=/home/vagrant/cache/xcache-1.3.2/modules/xcache.so > ~/.phpenv/versions/$(phpenv version-name)/etc/conf.d/xcache.ini
cat ~/.phpenv/versions/$(phpenv version-name)/etc/conf.d/xcache.ini
