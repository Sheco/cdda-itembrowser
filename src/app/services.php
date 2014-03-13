<?php
$app->singleton('Repositories\Recipe', 'Repositories\Recipe');
$app->singleton('Repositories\Item', 'Repositories\Item');
$app->singleton('Repositories\Material', 'Repositories\Material');
$app->singleton('Repositories\RepositoryInterface', 'Repositories\JsonCache');
