Contributing to the Item Browser
================================

The Item browser has two interfaces, the web application and a console 
command to rebuild the item database.

Console command
---------------

```
php src/artisan cataclysm:rebuild
```


The code for this command is located in 
[src/app/commands/CataclysmRebuild.php](src/app/commands/CataclsymRebuild.php).

When you run the console command, the fire() method is executed.

The main players here are the repositories and the indexers.

The repositories can be found in 
[src/app/models/Repositories](src/app/models/Repositories), 
there are two Repositories:

* **LocalRepository** is the main database parser, it finds the json files 
in a given path and loads them into memory.
* **CacheRepository** is the optimized database layer, it uses a 
LocalRepository and then stores the data in the cache.

Then there are the indexers, found in 
[src/app/models/Repositories/Indexers](src/app/models/Repositories/Indexers), 
there is one indexer for each type of object.

Each indexer will have two event listeners:

**onNewObject** is called when the LocalRepository loads a new object, 
the indexer will decide if it's interested and then add the object to 
the database index.

The index is hashtable, to add to it, you call $repo->set() like this:

```
$repo->set("someName.key", "value");
$repo->set("someName.id", "data");
$repo->set("items.toolset", 10);
$repo->set("items.fire", 12);
```

The database index will then have the following content:

```
array(
    "someName.key"=>"value",
    "someName.id"=>"data"
    "item.toolset"=>10,
    "item.fire"=>12
)
```

There's also a $repo->append() method which makes the value of the 
index an array and appends the value to the end, for example:

```
$repo->append("apps", "CDDA");
$repo->append("apps", "Item Browser");
```

This will result in an index like this:

```
array(
        "apps"=>array(
            "CDDA",
            "Item Browser"
        )
)
```

**onFinishedLoading** is called when all the data files are read, this is 
the last chance to reread everything and check some extra relationships.


Web Interface
-------------

The web interface has a few [controllers](src/app/controllers), one for 
items and another for monsters. 

Each controller action reads the repository to fetch the appropiate data, 
and then sends those values to the right [view](src/app/views).

The repository interface has a few available methods:

* raw($index) fetches a single raw value from the index.
* get($index) fetches an object from the database.
* getModel($model, $id) fetches an object and returns a model.
* getModelOrfail($model, $id) fetches an object and returns a model, if the 
object doesn't exist, raises an exception.
* allModels($model, $index) fetches all the values from the index and converts
each one to the appropiate model.

**Models** are an instance of a class found in [src/app/models](src/app/models), models have a special meaning for function calls starting with "get", they override the object's value with the return value of the function.

**Presenters** are like a copy of the model, but can override the model values
with escaped representations of it's former content. It can also provide new methods that are only available in the views, presenters have magic methods similar to the models, but start instead with "present".
