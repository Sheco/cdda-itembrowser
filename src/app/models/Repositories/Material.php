<?php
namespace Repositories;

class Material
{
  protected $database;
  protected $repo;

  const DEFAULT_INDEX = "materials";
  const ID_FIELD = "ident";

  public function __construct(RepositoryInterface $repo)
  {
    $this->repo = $repo;
    \Event::listen("cataclysm.newObject", function ($repo, $object) {
      $this->getIndexes($repo, $object);
    });
  }

  private function getIndexes($repo, $object)
  {
    if ($object->type=="material") {
      $repo->addIndex(self::DEFAULT_INDEX, $object->ident, $object->repo_id);
    }
  }

  public function model()
  {
    return \App::make("Material");
  }
}
