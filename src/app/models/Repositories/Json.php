<?php
namespace Repositories;

class Json implements RepositoryInterface
{
  protected $database;
  protected $index;
  private $id;

  public function __construct()
  {
    $this->id = 0;
    $this->index = array();
    $this->database = array();
  }

  // lazy load
  private function load()
  {
    if ($this->database)
      return;

    $this->read();
  }

  protected function loadObject($repo_id)
  {    
  }

  protected function loadIndex($index)
  {
  }

  private function newObject($object)
  {
    $object->repo_id = $this->id++;

    \Event::fire("cataclysm.newObject", array($this, $object));

    $this->database[$object->repo_id] = $object;
  }

  // read the data files and process them
  protected function read()
  {
    \Log::info("Reading data files...");
    $this->database = array();

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
  }

  // save an index to an object
  public function index($index, $key, $value)
  {
    $this->index[$index][$key] = $value;
  }

  // return a single object
  public function get($index, $id)
  {
    $this->load();
    $this->loadIndex($index);
    
    if (!isset($this->index[$index][$id]))
      return null;

    $db_id = $this->index[$index][$id];
    $this->loadObject($db_id);

    return $this->database[$db_id];
  }

  // return all the objects in the index
  public function all($index)
  {
    $this->load();
    $this->loadIndex($index);
    
    if (!isset($this->index[$index]))
      return array();

    return $this->index[$index];
  }

  public function version()
  {
    $version_file = \Config::get("cataclysm.dataPath")."/../../src/version.h";
    $data = @file_get_contents($version_file);
    return substr($data, 17, -2);
  }
}
