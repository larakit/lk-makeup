<?php
namespace Larakit\Makeup;

use Larakit\Helper\HelperFile;
use Larakit\ServiceProvider;

class LarakitServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    public function boot() {
        $this->larapackage('larakit/lk-makeup', 'lk-makeup');
        $this->makeupBlocks();
        $this->makeupPages();
        $this->makeupThemes();
    }

    function makeupThemes() {
        $themes_path = public_path('!/static/css/themes');
        if (!file_exists($themes_path))
            return true;
        $themes = [];
        foreach (\File::allFiles($themes_path) as $f) {
            $themes[] = str_replace('.css', '', $f->getFilename());
        }
        if(count($themes)) {
            \Larakit\Page\PageTheme::setThemes($themes);
        }

    }

    function makeupPages() {
        $pages_path = app_path('views/makeup/pages');
        $pages_path = HelperFile::normalizeFilePath($pages_path);
        if (!file_exists($pages_path))
            return true;
        foreach (\File::directories($pages_path) as $path) {
            $path = HelperFile::normalizeFilePath($path);
            Manager::register_page($path);
        }
    }

    function makeupBlocks() {
        $blocks_path = app_path('views/makeup/blocks');
        $blocks_path = HelperFile::normalizeFilePath($blocks_path);
        if (!file_exists($blocks_path))
            return true;
        foreach (\File::directories($blocks_path) as $path) {
            $path = HelperFile::normalizeFilePath($path);
            Manager::register_block($path);
        }
        \Larakit\StaticFiles\Manager::register('--common', app_path('views/makeup/common/static'));
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