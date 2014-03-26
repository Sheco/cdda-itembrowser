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

  public function read($path=null)
  {
    \Log::info("Reading data files...");
    if(!$path)
      $path = \Config::get('cataclysm.dataPath');

    $this->database = array();
    $this->id = 0;
    $this->index = array();

    $it = new \RecursiveDirectoryIterator("$path/data/json");
    foreach(new \RecursiveIteratorIterator($it) as $file) {
      $data = (array) json_decode(file_get_contents($file));
      array_walk($data, array($this, 'newObject'));
    }

    if (!$this->loadObject("item", "toolset")) {
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

    return array($this->database, $this->index);
  }

  // save an index to an object
  public function addIndex($index, $key, $value)
  {
    $this->index[$index][$key] = $value;
  }

  public function loadObject($index, $id)
  {    
    $indexDb = $this->loadIndex($index);
    if(!isset($indexDb[$id]))
      return null;
    $repo_id = $indexDb[$id];

    return $this->database[$repo_id];
  }

  public function loadIndex($index)
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
