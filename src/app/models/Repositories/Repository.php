<?php
namespace Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class Repository implements RepositoryInterface 
{
    public function getObjectOrFail($object, $id)
    {
        $repo = $this->app->make("Repositories\\Indexers\\$object");

        $data = $this->get($repo::DEFAULT_INDEX, $id);
        if (!$data) {
            throw new ModelNotFoundException();
        }

        $model = $this->app->make($object);
        $model->load($data);

        return $model;
    }

    public function getObject($object, $id)
    {
        $repo = $this->app->make("Repositories\\Indexers\\$object");

        $data = $this->get($repo::DEFAULT_INDEX, $id);

        $model = $this->app->make($object);

        if (!$data) {
            $model->loadDefault($id);
        } else {
            $model->load($data);
        }

        return $model;
    }

    public function allObjects($repo, $index = null)
    {
        if (!$index) {
            $repoInstance = $this->app->make("Repositories\\Indexers\\$repo");
            $index = $repoInstance::DEFAULT_INDEX;
        }

        $data = $this->all($index);

        array_walk($data, 
            function (&$value, $key) use ($repo) {
                $value = $this->getObject($repo, $key);
            }
        );

        return $data;
    }

    public function searchObjects($repo, $search)
    {
        \Log::info("searching for $search...");

        $results = array();
        if (!$search) {
            return $results;
        }

        foreach ($this->allObjects($repo) as $obj) {
            if ($obj->matches($search)) {
                $results[] = $obj;
            }
        }

        return $results;
    }
}
