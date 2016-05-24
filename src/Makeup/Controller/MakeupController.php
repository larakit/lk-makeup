<?php
namespace Larakit\Makeup\Controller;

use Alchemy\Zippy\Zippy;
use Larakit\Controller;
use Larakit\Makeup\Manager;
use Larakit\Page\Page;
use Larakit\Page\PageTheme;

class MakeupController extends Controller {

    protected $layout = 'lk-makeup::!.layouts.default';

    function index() {
        return $this->response();
    }

    function prepare_content($url) {
        $content = file_get_contents($url);
        $content = str_replace('href="//', 'href="http://', $content);
        $content = str_replace('src="//', 'src="http://', $content);
        $content = str_replace('href="/!', 'href="./!', $content);
        $content = str_replace('src="/!', 'src="./!', $content);
        $content = str_replace('href="/packages', 'href="./packages', $content);
        $content = str_replace('src="/packages', 'src="./packages', $content);

        return $content;
    }

    function download() {
        $blocks    = array_keys((array)\Larakit\Makeup\Manager::$blocks);
        $themes    = ['default' => 'default'] + \Larakit\Page\PageTheme::getThemes();
        $pages     = array_keys((array)\Larakit\Makeup\Manager::$pages);
        $contents  = [
            '!'        => public_path('!/'),
            'packages' => public_path('packages'),
        ];
        $tmp_names = [];
        if(!is_dir(storage_path('makeup/'))) {
            mkdir(storage_path('makeup/'), 0777, true);
        }
        $digest = [];
        foreach($pages as $page) {
            foreach($themes as $theme) {
                $name     = 'page_' . $page . '--' . $theme . '.html';
                $url      = url('/makeup/frame-page-' . $page . '?theme=' . $theme);
                $content  = $this->prepare_content($url);
                $tmp_name = storage_path('makeup/' . $name);
                file_put_contents($tmp_name, $content);
                $contents[$name]                = fopen($tmp_name, 'r');
                $tmp_names[]                    = $tmp_name;
                $digest['pages'][$page][$theme] = $name;
            }
        }
        foreach($blocks as $block) {
            foreach($themes as $theme) {
                $name     = 'block_' . $block . '--' . $theme . '.html';
                $url      = url('/makeup/frame-block-' . $block . '?theme=' . $theme);
                $content  = $this->prepare_content($url);
                $tmp_name = storage_path('makeup/' . $name);
                file_put_contents($tmp_name, $content);
                $contents[$name] = fopen($tmp_name, 'r');
                $tmp_names[]     = $tmp_name;
                $digest['blocks'][$block][$theme] = $name;
            }
        }
        $tmp_name = storage_path('makeup/index.html');
//        $tmp_names[]     = $tmp_name;
        file_put_contents($tmp_name, \View::make('lk-makeup::!.digest', ['digest'=>$digest])->__toString());
        $contents['index.html'] = fopen($tmp_name, 'r');
        //        dd(compact('path', 'theme', 'url', 'content'));

        // Creates an archive.zip that contains a directory "folder" that contains
        // files contained in "/path/to/directory" recursively
        // Load Zippy
        $zip_path = storage_path(date('H_i_s') . '.zip');
        $zippy    = Zippy::load();
        $zippy->create($zip_path, $contents, true);
        foreach($tmp_names as $tmp_name) {
            unlink($tmp_name);
        }

        return \Response::download($zip_path);
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

    function frameBlock() {
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

    function framePage() {
        $page  = \Route::input('page');
        $theme = \Request::input('theme');
        if($theme) {
            PageTheme::setCurrent($theme);
        }
        return $this->layout('larakit-makeup::pages.'.$page)
                    ->response([
                        'page'  => $page,
                        'theme' => $theme,
                    ]);
    }

}