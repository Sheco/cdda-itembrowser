<?php
namespace Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class Repository implements RepositoryInterface 
{
    protected $app;
    public function getModelOrFail($object, $id)
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

    public function getModel($object, $id)
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

    public function allModels($repo, $index = null)
    {
        if (!$index) {
            $repoInstance = $this->app->make("Repositories\\Indexers\\$repo");
            $index = $repoInstance::DEFAULT_INDEX;
        }

        $data = $this->all($index);

        array_walk($data, 
            function (&$value, $key) use ($repo) {
                $value = $this->getModel($repo, $key);
            }
        );

        return $data;
    }

    public function searchModels($repo, $search)
    {
        \Log::info("searching for $search...");

        $results = array();
        if (!$search) {
            return $results;
        }

        foreach ($this->allModels($repo) as $obj) {
            if ($obj->matches($search)) {
                $results[] = $obj;
            }
        }

        return $results;
    }
}
