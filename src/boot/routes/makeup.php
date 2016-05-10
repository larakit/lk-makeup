<?php
\Route::pattern('block', '[\w\d-_]+');
\Route::pattern('page', '[\w\d-_]+');

//****************************************
//  Главная
//****************************************
\Larakit\Route\Route::add('makeup')
                    ->setBaseUrl('/makeup')
                    ->setNamespace('Larakit\Makeup\Controller')
                    ->put();

\Larakit\Route\Route::add('makeup/block')
                    ->setBaseUrl('/makeup/block-{block}')
                    ->setNamespace('Larakit\Makeup\Controller')
                    ->setController('ControllerMakeup')
                    ->setAction('block')
                    ->put();

\Larakit\Route\Route::add('makeup/page')
                    ->setBaseUrl('/makeup/page-{page}')
                    ->setNamespace('Larakit\Makeup\Controller')
                    ->setController('ControllerMakeup')
                    ->setAction('page')
                    ->put();

\Larakit\Route\Route::add('makeup/frame_block')
                    ->setBaseUrl('/makeup/frame-block-{block}')
                    ->setNamespace('Larakit\Makeup\Controller')
                    ->setController('ControllerMakeup')
                    ->setAction('frame_block')
                    ->put();

\Larakit\Route\Route::add('makeup/frame_page')
                    ->setBaseUrl('/makeup/frame-page-{page}')
                    ->setNamespace('Larakit\Makeup\Controller')
                    ->setController('ControllerMakeup')
                    ->setAction('frame_page')
                    ->put();


\Larakit\Route\Route::add('lorempixel')
                    ->setBaseUrl('/!/lorempixel/{w}x{h}/{cat}/{number}.jpeg')
                    ->setNamespace('Larakit\Makeup\Controller')
                    ->setController('ControllerMakeup')
                    ->setAction('lorempixel')
                    ->put();


