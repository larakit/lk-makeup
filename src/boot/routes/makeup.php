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
    ->setController('ControllerMakeup')
    ->setAction('download')
    ->put();

\Larakit\Route\Route::group('makeup/block')
    ->setBaseUrl('/makeup/block-{block}')
    ->setNamespace('Larakit\Makeup\Controller')
    ->routeIndex()
    ->setController('ControllerMakeup')
    ->setAction('block')
    ->put();

\Larakit\Route\Route::group('makeup/page')
    ->setBaseUrl('/makeup/page-{page}')
    ->setNamespace('Larakit\Makeup\Controller')
    ->routeIndex()
    ->setController('ControllerMakeup')
    ->setAction('page')
    ->put();

\Larakit\Route\Route::group('makeup/frame_block')
    ->setBaseUrl('/makeup/frame-block-{block}')
    ->setNamespace('Larakit\Makeup\Controller')
    ->routeIndex()
    ->setController('ControllerMakeup')
    ->setAction('frame_page')
    ->put();

\Larakit\Route\Route::group('makeup/frame_page')
    ->setBaseUrl('/makeup/frame-page-{page}')
    ->setNamespace('Larakit\Makeup\Controller')
    ->routeIndex()
    ->setController('ControllerMakeup')
    ->setAction('frame_page')
    ->put();

\Larakit\Route\Route::group('lorempixel')
    ->setBaseUrl('/!/lorempixel/{w}x{h}/{cat}/{number}.jpeg')
    ->setNamespace('Larakit\Makeup\Controller')
    ->routeIndex()
    ->setController('ControllerMakeup')
    ->setAction('lorempixel')
    ->put();


