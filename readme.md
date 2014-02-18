## Cataclysm DDA Item/Recipe Browser

## Instalation

Using apache2

* You can use this sample configuration file. Assumes a vagrant environment with a vagrant.local hostname and the code stored in /vagrant/cataclysm-browser.

```
&lt;VirtualHost *:80>
ServerAdmin webmaster@localhost
ServerName cataclysm.local
ServerAlias cdda.estilofusion.com

DocumentRoot /vagrant/cataclysm-browser/public
&lt;Directory />
	Options FollowSymLinks
	AllowOverride None
&lt;/Directory>
&lt;Directory /vagrant/cataclysm-browser/public>
	Options Indexes FollowSymLinks MultiViews
	AllowOverride All
	Order allow,deny
	allow from all
&lt;/Directory>

ErrorLog ${APACHE_LOG_DIR}/error.log
LogLevel warn
CustomLog ${APACHE_LOG_DIR}/access.log combined
&lt;/VirtualHost>
```

* Then you have to have composer installed (http://getcomposer.org) and in the same directory as this readme file, run:

```
composer install
```

* Make sure the webserver has read/write access to everything inside app/storage
* Clone the https://github.com/CleverRaven/Cataclysm-DDA repository inside app/storage, or if you have it somewhere else, edit app/config/cataclysm.php and write the absolute path to the json data files.
* For performance, it's recommended to install php-apc and edit app/config/cache.php to change the following line. (Although a better way would be setting up the laravel environment in bootstrap/start.php and copying app/config/cache.php to the appropiate subdirectory)


```
	'driver' => 'apc',
```

### License

This application is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
