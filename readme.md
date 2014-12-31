Cataclysm DDA Item/Recipe Browser
=================================

This is a simple tool to browse through the items and recipes available in [Cataclysm: Dark Days Ahead](http://cataclysmdda.com), this is done by reading the game's data files and creating an optimized database linking everything together.

A copy of this code currently hosted by Sergio Duran (Sheco) at [http://cdda.estilofusion.com](http://cdda.estilofusion.com)

### Features

- Search for items
- Show how an item can be crafted
- Show recipes using each item.
- Automatic item catalogs, clothing, melee, ranged weapons, consumables, books, materials, qualities, flags, skills and gun mods.
- Monster catalogs.

### Installation

This can be used in a [Vagrant](https://www.vagrantup.com/) environment. The current scripts provided have been tested on the official ubuntu/trusty32 vagrant box.

To setup and run the environment, execute:

```
vagrant up
```

Everything should be up and running in a few minutes, you should be able to access the webapp at the appropiate address, it will probably be http://localhost:8000

### Manual instalation

If you don't want to run a vagrant setup, you only need to make sure you
have the appropiate dependencies.

* composer
* php5.4 (with the mcrypt extension)
* A webserver

Then you can run the setup.sh script, it expects a single argument, an
absolute path to install the data files and variable files.

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
