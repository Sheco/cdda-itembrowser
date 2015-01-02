<?php

namespace Repositories\Indexers;

interface IndexerInterface {
    function getIndexes($repo, $object);
    function finishedLoading($repo);
}
