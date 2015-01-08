<?php
namespace Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class Repository implements RepositoryInterface 
{
    protected $app;
    public function getModelOrFail($model, $id)
    {
        $indexer = $this->app->make("Repositories\\Indexers\\$model");

        $data = $this->get($indexer::DEFAULT_INDEX.".".$id);
        if (!$data) {
            throw new ModelNotFoundException();
        }

        $model = $this->app->make($model);
        $model->load($data);

        return $model;
    }

    public function getModel($model, $id)
    {
        $indexer = $this->app->make("Repositories\\Indexers\\$model");

        $data = $this->get($indexer::DEFAULT_INDEX.".".$id);

        $model = $this->app->make($model);

        if (!$data) {
            $model->loadDefault($id);
        } else {
            $model->load($data);
        }

        return $model;
    }

    public function allModels($model, $index = null)
    {
        if (!$index) {
            $indexer = $this->app->make("Repositories\\Indexers\\$model");
            $index = $indexer::DEFAULT_INDEX;
        }

        $data = $this->all($index);

        array_walk($data, 
            function (&$value) use ($model) {
                $value = $this->getModel($model, $value);
            }
        );

        return $data;
    }

    public function searchModels($model, $search)
    {
        \Log::info("searching for $search...");

        $results = array();
        if (!$search) {
            return $results;
        }

        foreach ($this->allModels($model) as $obj) {
            if ($obj->matches($search)) {
                $results[] = $obj;
            }
        }

        return $results;
    }
}
