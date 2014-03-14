<?php
namespace Repositories;

class Json implements RepositoryInterface
{
  protected $database;
  protected $index;
  protected $chunks;
  private $id;

  public function __construct()
  {
    $this->id = 0;
    $this->index = array();
    $this->chunks = array();
    $this->database = array();
  }

  // lazy load
  private function load()
  {
    if ($this->chunks)
      return;

    $this->read();
  }

  private function newObject($object)
  {
    $object->repo_id = $this->id++;
    \Event::fire("cataclysm.newObject", array($this, $object));
    $chunk = intval($object->repo_id/50);
    $this->chunks[$object->repo_id] = $chunk;
    $this->database[$chunk][$object->repo_id] = $object;
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

  protected function checkChunk($chunk)
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
    $chunk = $this->chunks[$db_id];
    $this->checkChunk($chunk);
    return $this->database[$chunk][$db_id];
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
