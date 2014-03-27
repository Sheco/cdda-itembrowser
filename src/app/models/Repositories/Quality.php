<?php
namespace Repositories;

class Quality
{
  protected $database;
  protected $repo;

  public function __construct(RepositoryInterface $repo)
  {
    $this->repo = $repo;
    \Event::listen("cataclysm.newObject", function ($repo, $object) {
      $this->getIndexes($repo, $object);
    });
  }

  private function getIndexes($repo, $object)
  {
    if ($object->type=="tool_quality")
    {
      $repo->addIndex("tool_quality", $object->id, $object->repo_id);
    }
  }

  public function get($id)
  {
    $quality = \App::make('Quality');
    $data = $this->repo->get("tool_quality", $id);
    if ($data)
      $quality->load($data);
    return $quality;
  }

  public function where($text)
  {
    throw new Exception(); // not implemented
  }

  public function all($name)
  {
    $ret = array();
    foreach($this->repo->all($name) as $id=>$item) {
      $ret[$id] = $this->get($id);
    }
    return $ret;
  }
}
