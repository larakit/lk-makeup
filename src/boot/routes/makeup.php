<?php
\Route::pattern('block', '[\w\d-_]+');
\Route::pattern('page', '[\w\d-_]+');

//****************************************
//  Главная
//****************************************
\Larakit\Route\Route::item('makeup')
                    ->setBaseUrl('/makeup')
                    ->setNamespace('Larakit\Makeup\Controller')
                    ->put();
\Larakit\Route\Route::item('makeup/download')
                    ->setBaseUrl('/makeup/download')
                    ->setNamespace('Larakit\Makeup\Controller')
                    ->setController('Makeup')
                    ->setAction('download')
                    ->put();
\Larakit\Route\Route::item('makeup/block')
                    ->setBaseUrl('/makeup/block-{block}')
                    ->setNamespace('Larakit\Makeup\Controller')
                    ->setController('Makeup')
                    ->setAction('block')
                    ->put();
\Larakit\Route\Route::item('makeup/page')
                    ->setBaseUrl('/makeup/page-{page}')
                    ->setNamespace('Larakit\Makeup\Controller')
                    ->setController('Makeup')
                    ->setAction('page')
                    ->put();
\Larakit\Route\Route::item('makeup/frame_block')
                    ->setBaseUrl('/makeup/frame-block-{block}')
                    ->setNamespace('Larakit\Makeup\Controller')
                    ->setController('Makeup')
                    ->setAction('frameBlock')
                    ->put();
\Larakit\Route\Route::item('makeup/frame_page')
                    ->setBaseUrl('/makeup/frame-page-{page}')
                    ->setNamespace('Larakit\Makeup\Controller')
                    ->setController('Makeup')
                    ->setAction('framePage')
                    ->put();