<?php

namespace Repositories\Indexers;

interface IndexerInterface
{
    public function onNewObject($repo, $object);
    public function onFinishedLoading($repo);
}
