<?php

namespace Repositories;

interface RepositoryWriterInterface
{
    function raw($index);
    function set($index, $value);
    function append($index, $value);
    function addUnique($index, $value);
    function sort($index);
}
