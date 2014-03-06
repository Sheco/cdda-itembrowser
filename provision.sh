#!/bin/bash
# tested on a debian 7.3 box

# download packages
apt-get update
apt-get -y install php5 php5-mcrypt php5-mysql avahi-daemon php-apc unzip

# setup apache2
cp /vagrant/sites-available/* /etc/apache2/sites-available
a2ensite cataclysm
a2enmod rewrite
service apache2 restart

# make var paths
mkdir -p /var/cache/cataclysm/{vendor,storage/{cache,logs,meta,sessions,views}}
chmod -R g+w /var/cache/cataclysm
chown vagrant:www-data -R /var/cache/cataclysm

# download the cataclysm dda's source code
cd /vagrant
[ ! -e master.zip ] && wget https://github.com/CleverRaven/Cataclysm-DDA/archive/master.zip
sudo -u vagrant unzip -d /var/cache/cataclysm/storage master.zip

# download composer
cd /usr/local/bin
curl -sS https://getcomposer.org/installer | php -- --filename=composer

# download php dependencies
cd /vagrant/src
rm -f composer.lock
sudo -u vagrant composer install
