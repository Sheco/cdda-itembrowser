#!/bin/sh
# tested on a ubuntu 14.04 box
# this is script would normally be ran only once per server
# it downloads the system dependencies needed for the app

BASE_PATH=/vagrant
USER=vagrant
STORAGE_PATH=/vagrant/src/app/storage

# exit on error
set -e

# download packages
apt-get update
apt-get -y install php5 php5-mcrypt php-apc unzip memcached

# setup php
php5enmod mcrypt

# setup apache2
a2enmod rewrite
sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
service apache2 reload
rm -fr /var/www/html
ln -sf "$BASE_PATH"/src/public /var/www/html

# download composer
curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin

chown $USER "$STORAGE_PATH"

sudo -u $USER "$BASE_PATH"/setup.sh

echo "Giving access to the webserver"
chgrp -R www-data "$STORAGE_PATH"/*
chmod -R g+ws "$STORAGE_PATH"/*
