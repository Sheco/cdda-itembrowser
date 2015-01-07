<?php
namespace Repositories;

class CacheRepository extends LocalRepository implements RepositoryInterface
{
    private $repo;

    public function __construct()
    {
        $this->repo = \App::make('cache.store');
    }

    public function read()
    {
    }

    public function compile(LocalRepository $reader)
    {
        list($database, $index) = $reader->read();

        foreach ($database as $repo_id => $object) {
            $this->repo->forever("cdda:db:$repo_id", $object);
        }

        foreach ($index as $id => $data) {
            $this->repo->forever("cdda:index:$id", $data);
        }
        $this->repo->forever("cdda:version", $reader->version());
    }

    public function get($index, $id)
    {
        $indexDb = $this->all($index);
        if (!isset($indexDb[$id])) {
            return;
        }

        $repo_id = $indexDb[$id];

        if (!isset($this->database[$repo_id])) {
            $this->database[$repo_id] = $this->repo->get("cdda:db:$repo_id");
        }

        return $this->database[$repo_id];
    }

    public function all($index)
    {
        if (!isset($this->index[$index])) {
            $this->index[$index] = $this->repo->get("cdda:index:$index")?: array();
        }

        return $this->index[$index];
    }

    public function searchObjects($repo, $search)
    {
        $key = "search:$repo:".str_replace(" ", "!", $search);

        $expiration = \Config::get("cataclysm.searchCacheExpiration");

        $repoInstance = \App::make("Repositories\\Indexers\\$repo");
        $idField = $repoInstance::ID_FIELD;

        $objects = \Cache::remember($key, $expiration, 
            function () use ($repo, $search, $idField) {
                $objects = parent::searchObjects($repo, $search);
                array_walk($objects, function (&$object) use ($idField) {
                    $object = $object->$idField;
                });

            return $objects;
        });

        array_walk($objects, 
            function (&$object) use ($repo) {
                $object = $this->getObject($repo, $object);
            });

        return $objects;
    }
    public function version()
    {
        return $this->repo->get("cdda:version");
    }
}
