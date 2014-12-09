#!/bin/sh
# exit on error
set -e

if test -z $1
then
  echo "Please provide the path for the data files"
  exit 1
fi
# get the absolute path to the data files
BASE_PATH=$(cd $(dirname $0 ) && pwd )
DATA_PATH=$(realpath $1)

cd "$BASE_PATH"
# make storage paths
mkdir -p "$DATA_PATH"/vendor
for dir in cache logs meta sessions views database
do mkdir -p "$DATA_PATH"/storage/$dir
done
chmod -R g+w "$DATA_PATH"

# download the cataclysm dda's source code
[ ! -e master.zip ] && wget https://github.com/CleverRaven/Cataclysm-DDA/archive/master.zip
unzip -d "$DATA_PATH/storage" master.zip
mv "$DATA_PATH/storage/Cataclysm-DDA-master" "$DATA_PATH/storage/Cataclysm-DDA"

# edit some files, set the appropiate paths
sed -i "s@require\s\+.*vendor/autoload.php.*@require '$DATA_PATH/vendor/autoload.php';@" src/bootstrap/autoload.php
sed -i "s@'storage'\s\+=>.*@'storage' => '$DATA_PATH/storage',@" src/bootstrap/paths.php
sed -i "s@\$framework\s\+=.*@\$framework = '$DATA_PATH/vendor/laravel/framework/src';@" src/bootstrap/start.php
sed -i "s@\"vendor-dir\"\s*:\s*\"[^\"]*\"@\"vendor-dir\": \"$DATA_PATH/vendor\"@" src/composer.json


# download php dependencies
(
cd src
rm -f composer.lock
composer install
php artisan cataclysm:rebuild
)

echo "--------------------------"
echo "You need to make sure the webserver can read/write to the storage path"
echo ": $DATA_PATH/storage"
