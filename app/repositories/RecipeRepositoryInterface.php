<?php

interface RecipeRepositoryInterface
{
  public function find($id);
  public function where($text);
  public function parse();
}
