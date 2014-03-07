#!/bin/sh
# tested on a debian 7.3 box
# this is script would normally be ran only once per server
# it downloads the system dependencies needed for the app

BASE_PATH=/vagrant
USER=vagrant
DATA_PATH=/var/cache/cataclysm

# exit on error
set -e

# download packages
apt-get update
apt-get -y install php5 php5-mcrypt php5-mysql avahi-daemon php-apc unzip

# setup apache2
cp "$BASE_PATH"/sites-available/* /etc/apache2/sites-available
a2ensite cataclysm
a2enmod rewrite
service apache2 restart

# download composer
curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin

mkdir -p "$DATA_PATH"
chown $USER "$DATA_PATH"
sudo -u $USER "$BASE_PATH"/setup.sh "$DATA_PATH"
echo "Giving access to the webserver"
chgrp -R www-data "$DATA_PATH"/storage/*
