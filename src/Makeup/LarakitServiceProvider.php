<?php
namespace Larakit\Makeup;

use Larakit\Helper\HelperFile;
use Larakit\ServiceProvider;
use Larakit\StaticFiles\Css;
use TwigBridge\Engine\Twig;

class LarakitServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot() {
        Manager::setPrefix(env('MAKEUPDIR', '!/static'));
        $this->larapackage('larakit/lk-makeup', 'lk-makeup');
        $this->loadViewsFrom(Manager::getPath(), 'larakit-makeup');
        $this->makeupBlocks();
        $this->makeupPages();
        $this->makeupThemes();
    }

    function makeupThemes() {
        $themes_path = Manager::getPath('themes');
        if(file_exists($themes_path)) {
            $themes = [];
            $theme  = \Request::input('theme');
            \Larakit\StaticFiles\Manager::package('makeup-themes')
                ->usePackage('makeup-blocks');

            foreach(\File::allFiles($themes_path) as $f) {
                $name = str_replace('.css', '', $f->getFilename());
                if($theme == $name) {
                    \Larakit\StaticFiles\Manager::package('makeup-themes')
                        ->css(Manager::getUrl('themes/' . $name . '.css'));
                }
                $themes[$name] = $name;
            }
            if(count($themes)) {
                \Larakit\Page\PageTheme::setThemes($themes);
            }
        }
    }

    function makeupPages() {
        $pages_path = Manager::getPath('pages');
        if(file_exists($pages_path)) {
            foreach(\File::allFiles($pages_path) as $file) {
                Manager::page(str_replace('.twig', '', $file->getFilename()));
            }
        }
    }

    function makeupBlocks() {
        $blocks_path = HelperFile::normalizeFilePath(Manager::getPath('blocks'));
        if(file_exists($blocks_path)) {
            foreach(\File::directories($blocks_path) as $path) {
                $path = HelperFile::normalizeFilePath($path);
                Manager::block(trim(str_replace($blocks_path, '', $path), '/'));
            }
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return [];
    }

}