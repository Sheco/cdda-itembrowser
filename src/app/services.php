<?php
$app->singleton('RepositoryInterface', 'JsonRepositoryCache');
$app->singleton('ItemRepositoryInterface', 'ItemRepository');
$app->singleton('RecipeRepositoryInterface', 'RecipeRepository');
$app->singleton('MaterialRepositoryInterface', 'MaterialRepository');
