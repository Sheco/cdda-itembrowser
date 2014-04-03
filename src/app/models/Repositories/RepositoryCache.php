<?php
namespace Repositories;

class RepositoryCache extends Repository
{
  public function __construct(RepositoryReaderInterface $reader)
  {
    parent::__construct(new CacheReader($reader));
  }

  public function searchObjects($repo, $search) 
  {
    $key = "search:$repo:".str_replace(" ", "!", $search);

    $expiration = \Config::get("cataclysm.searchCacheExpiration");

    $repoInstance = \App::make("Repositories\\Indexers\\$repo");
    $idField = $repoInstance::ID_FIELD;

    $objects = \Cache::remember($key, $expiration, function () use ($repo, $search, $idField) {
      $objects = parent::searchObjects($repo, $search);
      array_walk($objects, function (&$object) use ($idField) { 
        $object = $object->$idField;
      });
      return $objects;
    });

    array_walk($objects, function (&$object) use ($repo) {
      $object = $this->getObject($repo, $object);
    });
    return $objects;
  }
}
