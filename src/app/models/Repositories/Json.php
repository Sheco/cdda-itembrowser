<?php
namespace Repositories;

class Json implements RepositoryInterface
{
  protected $database;
  protected $index;
  protected $hashes;
  private $id;

  public function __construct()
  {
    $this->id = 0;
    $this->index = array();
    $this->hashes = array();
    $this->database = array();
  }

  // lazy load
  private function load()
  {
    if ($this->hashes)
      return;

    $this->read();
  }

  private function newObject($object)
  {
    $object->repo_id = $this->id++;
    \Event::fire("cataclysm.newObject", array($this, $object));
    $hash = intval($object->repo_id/50);
    $this->hashes[$object->repo_id] = $hash;
    $this->database[$hash][$object->repo_id] = $object;
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
    $this->newObject(json_decode('{"id":"toolset","name":"integrated toolset","type":"_SPECIAL"}'));
    $this->newObject(json_decode('{"id":"fire","name":"nearby fire","type":"_SPECIAL"}'));
  }

  protected function checkHash($hash)
  {
  }

  // save an index to an object
  public function index($index, $key, $object)
  {
    $this->index[$index][$key] = $object->repo_id;
  }

  // return a single object
  public function get($index, $id)
  {
    $this->load();
    
    if (!isset($this->index[$index][$id]))
      return null;
    $db_id = $this->index[$index][$id];
    $hash = $this->hashes[$db_id];
    $this->checkHash($hash);
    return $this->database[$hash][$db_id];
  }

  // return all the objects in the index
  public function all($index)
  {
    $this->load();
    
    if (!isset($this->index[$index]))
      return array();

    return $this->index[$index];
  }
}
