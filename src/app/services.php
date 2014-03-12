<?php
$app->singleton('RepositoryInterface', 'JsonRepository');
$app->singleton('ItemRepositoryInterface', 'ItemRepositoryCache');
$app->singleton('RecipeRepositoryInterface', 'RecipeRepositoryCache');
$app->singleton('MaterialRepositoryInterface', 'MaterialRepositoryCache');
$app->singleton('ItemRepositoryPivotInterface', 'ItemRepositoryPivotCache');
