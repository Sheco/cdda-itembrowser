#!/bin/bash
# tested on a debian 7.3 box
# get the absolute path to the data files
BASE_PATH=$(cd $(dirname $0 ) && pwd )
STORAGE_PATH=/var/cache/cataclysm
USER=vagrant
WWW_USER=www-data

# if this script is run with one argument, that'll be the storage path.
[ "$1" != "" ] && STORAGE_PATH=$1

# edit some files, set the appropiate paths
sed -i "s@require\s\+.*vendor/autoload.php.*@require '$STORAGE_PATH/vendor/autoload.php';@" $BASE_PATH/src/bootstrap/autoload.php
sed -i "s@'storage'\s\+=>.*@'storage' => '$STORAGE_PATH/storage',@" $BASE_PATH/src/bootstrap/paths.php
sed -i "s@\$framework\s\+=.*@\$framework = '$STORAGE_PATH/vendor/laravel/framework/src';@" $BASE_PATH/src/bootstrap/start.php
sed -i "s@\"vendor-dir\"\s*:\s*\"[^\"]*\"@\"vendor-dir\": \"$STORAGE_PATH/vendor\"@" $BASE_PATH/src/composer.json

# download packages
apt-get update
apt-get -y install php5 php5-mcrypt php5-mysql avahi-daemon php-apc unzip

# setup apache2
cp $BASE_PATH/sites-available/* /etc/apache2/sites-available
a2ensite cataclysm
a2enmod rewrite
service apache2 restart

# make storage paths
mkdir -p $STORAGE_PATH/{vendor,storage/{cache,logs,meta,sessions,views}}
chmod -R g+w $STORAGE_PATH
chown $USER:$WWW_USER -R $STORAGE_PATH

# download the cataclysm dda's source code
cd $BASE_PATH
[ ! -e master.zip ] && wget https://github.com/CleverRaven/Cataclysm-DDA/archive/master.zip
sudo -u $USER unzip -d $STORAGE_PATH/storage master.zip

# download composer
cd /usr/local/bin
curl -sS https://getcomposer.org/installer | php -- --filename=composer

# download php dependencies
cd $BASE_PATH/src
rm -f composer.lock
sudo -u $USER composer install
