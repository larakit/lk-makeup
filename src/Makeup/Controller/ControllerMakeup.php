<?php
namespace Larakit\Makeup\Controller;

use Illuminate\Support\Arr;
use Larakit\Controller\ControllerIndex;
use Larakit\Helper\HelperFile;
use Larakit\Makeup\Manager;
use Larakit\Page\Page;
use Larakit\Page\PageTheme;

class ControllerMakeup extends ControllerIndex {

    protected $layout = 'lk-makeup::!.layouts.default';

    function __construct() {
        parent::__construct();
        $this->addBreadCrumb('makeup');
    }

    function index() {
        return $this->response();
    }

    function download() {
        $path  = \Request::input('path');
        $theme = \Request::input('theme');
        $url = url(str_replace('/', '/frame-', $path)).'?theme='.$theme;
        $content = file_get_contents($url);
        $content = str_replace('href="/!', 'href="./!', $content);
        $content = str_replace('href="/packages', 'href="./packages', $content);
        dd(compact('path', 'theme', 'url', 'content'));
        return $this->response();
    }

    function block() {
        $block = \Route::input('block');
        $theme = \Request::input('theme');

        return $this->layout('lk-makeup::!.layouts.block')
                    ->response([
                        'blocks' => Manager::$blocks,
                        'theme'  => $theme,
                        'sizes'  => Manager::$breakpoints,
                        'block'  => $block,
                    ]);
    }

    function page() {
        $page  = \Route::input('page');
        $theme = \Request::input('theme');

        return $this->layout('lk-makeup::!.layouts.page')
                    ->response([
                        'pages' => Manager::$pages,
                        'theme' => $theme,
                        'sizes' => Manager::$breakpoints,
                        'page'  => $page,
                    ]);
    }

    function frame_block() {
        $block = \Route::input('block');
        Page::body()
            ->setAttribute('class', '');
        $theme = \Request::input('theme');
        if($theme) {
            Page::body()
                ->addClass('theme--' . $theme);
        }

        return $this->layout('lk-makeup::!.layouts.frame_block')
                    ->response([
                        'block' => $block,
                        'theme' => $theme,
                    ]);
    }

    function frame_page() {
        $page  = \Route::input('page');
        $theme = \Request::input('theme');
        if($theme) {
            PageTheme::setCurrent($theme);
        }

        return $this->layout('lk-makeup::!.layouts.frame_page')
                    ->response([
                        'page'  => $page,
                        'theme' => $theme,
                    ]);
    }

}