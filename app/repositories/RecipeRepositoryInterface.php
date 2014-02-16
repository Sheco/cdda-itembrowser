<?php

interface RecipeRepositoryInterface
{
  public function find($id);
  public function where($text);
}
