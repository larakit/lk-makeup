<?php
\Route::pattern('block', '[\w\d-_]+');
\Route::pattern('page', '[\w\d-_]+');

//****************************************
//  Главная
//****************************************
\Larakit\Route\Route::group('makeup')
    ->setBaseUrl('/makeup')
    ->setNamespace('Larakit\Makeup\Controller')
    ->routeIndex()
    ->put();

\Larakit\Route\Route::group('makeup/download')
    ->setBaseUrl('/makeup/download')
    ->setNamespace('Larakit\Makeup\Controller')
    ->routeIndex()
    ->setController('Makeup')
    ->setAction('download')
    ->put();

\Larakit\Route\Route::group('makeup/block')
    ->setBaseUrl('/makeup/block-{block}')
    ->setNamespace('Larakit\Makeup\Controller')
    ->routeIndex()
    ->setController('Makeup')
    ->setAction('block')
    ->put();

\Larakit\Route\Route::group('makeup/page')
    ->setBaseUrl('/makeup/page-{page}')
    ->setNamespace('Larakit\Makeup\Controller')
    ->routeIndex()
    ->setController('Makeup')
    ->setAction('page')
    ->put();

\Larakit\Route\Route::group('makeup/frame_block')
    ->setBaseUrl('/makeup/frame-block-{block}')
    ->setNamespace('Larakit\Makeup\Controller')
    ->routeIndex()
    ->setController('Makeup')
    ->setAction('frameBlock')
    ->put();

\Larakit\Route\Route::group('makeup/frame_page')
    ->setBaseUrl('/makeup/frame-page-{page}')
    ->setNamespace('Larakit\Makeup\Controller')
    ->routeIndex()
    ->setController('Makeup')
    ->setAction('framePage')
    ->put();

\Larakit\Route\Route::group('lorempixel')
    ->setBaseUrl('/!/lorempixel/{w}x{h}/{cat}/{number}.jpeg')
    ->setNamespace('Larakit\Makeup\Controller')
    ->routeIndex()
    ->setController('Makeup')
    ->setAction('lorempixel')
    ->put();


