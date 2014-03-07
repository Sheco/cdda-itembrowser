## Cataclysm DDA Item/Recipe Browser

### Instalation

This is a vagrant environment, you only need to have a compatible debian box
installed in your computer and run vagrant up. Edit Vagrantfile to 
change the box name if needed.

I downloaded debian 7.3 from Puppet Labs: 
http://puppet-vagrant-boxes.puppetlabs.com/

Everything should be up and running in a few minutes.

### Manual instalation

If you don't want to run a vagrant setup, you only need to make sure you
have the appropiate dependencies.

* composer
* php5.3 (with the mcrypt extension)
* It's recommended to have the php apc extension.
* A webserver, I've included a sample config file for apache.

Then you can run the setup.sh script, it expects a single argument, a
path to install the data files and variable files.

The webserver should be able to read and write the files in the "storage"
directory inside the data file path.

### Multiple instances

If you need to run multiple instances on the same server, you can get a new
copy of this repository and then call the setup.sh script as a regular user
with an extra argument, the path to install the extra resources and data. 

Remember to give the webserver read/write access to the storage directory
in the data installation path.

You then need to create a new apache virtualhost.

### License

This application is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
