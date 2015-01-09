<?php
namespace Repositories;

class CacheRepository extends Repository implements RepositoryInterface,
    RepositoryParserInterface
{
    private $repo;
    private $source;
    private $expiration;

    public function __construct(
        \Illuminate\Cache\Repository $repo,
        \Illuminate\Foundation\Application $app
    )
    {
        $this->repo = $repo;
        $this->app = $app;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    public function read()
    {
        list($database, $index) = $this->source->read();

        foreach ($database as $repo_id => $object) {
            $this->repo->forever("cdda:db:$repo_id", $object);
        }

        foreach ($index as $id => $data) {
            $this->repo->forever("cdda:index:$id", $data);
        }
        $this->repo->forever("cdda:version", $this->source->version());
        return [$database, $index];
    }

    public function get($index, $default=null)
    {
        $repo_id = $this->raw($index, $default);

        if (!isset($this->database[$repo_id])) {
            $this->database[$repo_id] = $this->repo->get("cdda:db:$repo_id");
        }

        return $this->database[$repo_id];
    }

    public function raw($index, $default=array())
    {
        if (!isset($this->index[$index])) {
            $this->index[$index] = $this->repo->get("cdda:index:$index")?: $default;
        }

        return $this->index[$index];
    }

    public function searchModels($model, $search)
    {
        $key = "search:$model:".str_replace(" ", "!", $search);

        $objects = $this->repo->rememberForever($key,
            function () use ($model, $search) {
                $objects = parent::searchModels($model, $search);
                array_walk($objects, function (&$object) {
                    $object = $object->id;
                });

            return $objects;
        });

        array_walk($objects, 
            function (&$object) use ($model) {
                $object = $this->getModel($model, $object);
            });

        return $objects;
    }
    public function version()
    {
        return $this->repo->get("cdda:version");
    }
}
