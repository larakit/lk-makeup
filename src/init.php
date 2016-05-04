<?php
larakit_provider(\Larakit\Makeup\LarakitServiceProvider::class);
\Larakit\StaticFiles\StaticLoader::where('makeup*', [
    'larakit',
    'font-awesome',
    'makeup'
]);
\Larakit\StaticFiles\StaticLoader::where('makeup/frame_*', [
]);