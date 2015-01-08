<?php
namespace Repositories;

interface RepositoryInterface
{
    public function get($index);
    public function getModelOrFail($model, $id);
    public function getModel($model, $id);

    public function raw($index);
    public function allModels($model, $index = null);

    public function searchModels($model, $search);

    public function version();
}
