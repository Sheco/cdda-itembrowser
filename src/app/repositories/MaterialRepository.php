<?php

class MaterialRepository implements MaterialRepositoryInterface
{
  protected $database;
  protected $repo;

  public function __construct(RepositoryInterface $repo)
  {
    $this->repo = $repo;
    Event::listen("cataclysm.newObject", function($repo, $object)
    {
      $this->getIndexes($repo, $object);
    });
  }

  private function getIndexes($repo, $object)
  {
    if($object->type=="material")
      $repo->addIndex("material", $object->ident, $object);
  }

  public function find($id)
  {
    $material = App::make('Material');
    $data = $this->repo->get("material", $id);
    if($data)
      $material->load($data);
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
