<?php
$app->singleton('ItemRepositoryInterface', 'ItemRepositoryCache');
$app->singleton('RecipeRepositoryInterface', 'RecipeRepositoryCache');
$app->singleton('MaterialRepositoryInterface', 'MaterialRepositoryCache');
