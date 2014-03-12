<?php

class MaterialRepository implements MaterialRepositoryInterface, IndexerInterface
{
  protected $database;
  protected $repo;

  public function __construct(RepositoryInterface $repo)
  {
    $this->repo = $repo;
  }

  public function getIndexes($object)
  {
    $indexes = array();
    if($object->type=="material")
      $indexes["material"] = $object->ident;
    return $indexes;
  }

  public function find($id)
  {
    $material = App::make('Material');
    $data = $this->repo->get("material", $id);
    if($data)
      $material->load($this->database[$id]);
    return $material;
  }

  public function where($text)
  {
    throw new Exception(); // not implemented
  }

  public function all()
  {
    throw new Exception();
  }
}
