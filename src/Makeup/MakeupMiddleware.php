<?php
/**
 * Created by Larakit.
 * Link: http://github.com/larakit
 * User: Alexey Berdnikov
 * Date: 04.05.16
 * Time: 13:58
 */

namespace Larakit\Makeup;

class MakeupMiddleware {

    public function handle($request, \Closure $next) {
        $dir = resource_path('views/!/makeup/blocks');
        if(is_dir($dir)) {
            $blocks = \File::allFiles($dir);
            foreach($blocks as $block) {
                $b = str_replace('.twig', '', $block->getFilename());
                Manager::block($b);
            }
        }

        $dir = resource_path('views/!/makeup/pages');
        if(is_dir($dir)) {
            $pages = \File::allFiles($dir);
            foreach($pages as $page) {
                $p = str_replace('.twig', '', $page->getFilename());
                Manager::page($p);
            }
        }

        return $next($request);
    }
}