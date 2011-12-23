#! /bin/sh
wget http://xcache.lighttpd.net/pub/Releases/1.3.2/xcache-1.3.2.tar.gz
tar -zxf xcache-*.tar.gz
cd xcache-1.3.2
phpize
./configure --enable-xcache
make
su
make install
cp xcache.ini ~/.phpenv/versions/$(phpenv version-name)/etc/conf.d
rm ~/.phpenv/versions/$(phpenv version-name)/etc/conf.d/xdebug.ini
