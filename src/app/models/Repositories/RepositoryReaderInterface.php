<?php

namespace Repositories;

interface RepositoryReaderInterface
{
    public function read($path = null);
    public function get($index, $id);
    public function all($index);
    public function version();
}
