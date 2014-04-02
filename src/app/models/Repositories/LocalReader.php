<?php
namespace Repositories;

class LocalReader implements RepositoryReaderInterface
{
  private $id;
  private $database;
  private $index;
  private $version;

  private function newObject($object)
  {
    $object->repo_id = $this->id++;

    \Event::fire("cataclysm.newObject", array($this, $object));

    $this->database[$object->repo_id] = $object;
  }

  private function modDirectory($path, $id)
  {
    $mods = array_filter(glob("$path/data/mods/*"), "is_dir");
    foreach ($mods as $mod) {
      $modinfo = json_decode(file_get_contents("$mod/modinfo.json"));
      if ($modinfo->ident == $id)
        return $mod;
    }
  }

  private function dataPaths($path)
  {
    $default_mods_data = json_decode(file_get_contents("$path/data/mods/dev-default-mods.json"));
    $paths = array("$path/data/json");

    foreach ($default_mods_data->dependencies as $mod) {
      $paths[] = $this->modDirectory($path, $mod);
    }
    return $paths;
  }

  public function read($path=null)
  {
    \Log::info("Reading data files...");
    if(!$path)
      $path = \Config::get('cataclysm.dataPath');

    $this->database = array();
    $this->id = 0;
    $this->index = array();

    $paths = $this->dataPaths($path);

    foreach ($paths as $path) {
      $it = new \RecursiveDirectoryIterator($path);
      foreach(new \RecursiveIteratorIterator($it) as $file) {
        $data = (array) json_decode(file_get_contents($file));

        if(substr($file, -12)!="modinfo.json") {        
          array_walk($data, array($this, 'newObject'));
        }
      }
    }

    if (!$this->get("item", "toolset")) {
      $this->newObject(json_decode('{
        "id":"toolset",
        "name":"integrated toolset",
        "type":"_SPECIAL",
        "description":"A fake item. If you are reading this it\'s a bug!"
      }'));
    }
    $this->newObject(json_decode('{
      "id":"fire",
      "name":"nearby fire",
      "type":"_SPECIAL",
      "description":"A fake item. If you are reading this it\'s a bug!"
    }'));
    $this->newObject(json_decode('{
      "id":"cvd_machine",
      "name":"cvd machine",
      "type":"_SPECIAL",
      "description":"A fake item. If you are reading this it\'s a bug!"
    }'));
    $this->newObject(json_decode('{
      "id":"apparatus",
      "name":"a smoking device and a source of flame",
      "type":"_SPECIAL",
      "description":"A fake item. If you are reading this it\'s a bug!"
    }'));


    $this->version = $this->getVersion($path);

    \Event::fire("cataclysm.finishedLoading", array($this));

    return array($this->database, $this->index);
  }

  // save an index to an object
  public function addIndex($index, $key, $value)
  {
    $this->index[$index][$key] = $value;
  }

  public function get($index, $id)
  {    
    $indexDb = $this->all($index);
    if(!isset($indexDb[$id]))
      return null;
    $repo_id = $indexDb[$id];

    return $this->database[$repo_id];
  }

  public function all($index)
  {
    if (!isset($this->index[$index]))
      return array();
    return $this->index[$index];
  }

  public function getVersion($path)
  {
    $version_file = "$path/src/version.h";
    $data = @file_get_contents($version_file);
    return substr($data, 17, -2);
  }

  public function version()
  {
    return $this->version;
  }
}
