<?php

namespace Repositories\Indexers;

interface IndexerInterface
{
    public function getIndexes($repo, $object);
    public function finishedLoading($repo);
}
