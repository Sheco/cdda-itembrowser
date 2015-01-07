#!/bin/sh
# exit on error
set -e

# get the absolute path to the data files
BASE_PATH=$(cd $(dirname $0 ) && pwd )
STORAGE_PATH="src/app/storage"

cd "$BASE_PATH"

# download the cataclysm dda's source code
if [ ! -e master.zip ]
then
    echo "Downloading game source and data files..."
    curl -LOs https://github.com/CleverRaven/Cataclysm-DDA/archive/master.zip
fi

echo "Unzipping..."
unzip -qo master.zip

# download php dependencies
composer -d=src install
php src/artisan cataclysm:rebuild Cataclysm-DDA-master

echo "--------------------------"
echo "You need to make sure the webserver can read/write to the storage path"
echo ": $STORAGE_PATH"
