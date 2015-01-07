<?php
namespace Repositories;

interface RepositoryParserInterface
{
    public function setSource($source);
    public function read();
}
