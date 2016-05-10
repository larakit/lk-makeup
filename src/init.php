<?php
Larakit\Boot::register_provider(\Larakit\Makeup\LarakitServiceProvider::class);
Larakit\Boot::register_middleware(\Larakit\Makeup\MakeupMiddleware::class);
//\Larakit\StaticFiles\StaticLoader::where(
//    'makeup*',
//    [
//        'larakit',
//        'font-awesome',
//        'makeup',
//    ]
//);
//
//\Larakit\StaticFiles\StaticLoader::where('makeup/frame_*', []);
//
\Larakit\StaticFiles\Manager::package('larakit/lk-makeup')
                            ->usePackage('larakit/sf-bootstrap')
                            ->jsPackage('js/makeup.js')
                            ->cssPackage('css/makeup.css')
                            ->setSourceDir('public')
                            ->addExclude('*')
                            ->addExclude('makeup/frame*')
                            ->addInclude('makeup*');
\Larakit\StaticFiles\Manager::package('larakit/sf-bootstrap')
    ->addExclude('makeup/frame*');
