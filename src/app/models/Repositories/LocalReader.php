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

  public function read()
  {
    \Log::info("Reading data files...");

    $this->database = array();
    $this->id = 0;
    $this->index = array();

    $it = new \RecursiveDirectoryIterator(\Config::get("cataclysm.dataPath"));
    foreach(new \RecursiveIteratorIterator($it) as $file) {
      $data = (array) json_decode(file_get_contents($file));
      array_walk($data, array($this, 'newObject'));
    }

    $this->newObject(json_decode('{
      "id":"toolset",
      "name":"integrated toolset",
      "type":"_SPECIAL"
    }'));
    $this->newObject(json_decode('{
      "id":"fire",
      "name":"nearby fire",
      "type":"_SPECIAL"
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
