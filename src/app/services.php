<?php
$app->singleton('ItemRepositoryInterface', 'ItemRepositoryCache');
$app->singleton('RecipeRepositoryInterface', 'RecipeRepositoryCache');
$app->singleton('MaterialRepositoryInterface', 'MaterialRepositoryCache');
$app->singleton('ItemRepositoryPivotInterface', 'ItemRepositoryPivotCache');
