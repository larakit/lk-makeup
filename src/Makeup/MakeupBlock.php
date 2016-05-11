<?php
/**
 * Created by Larakit.
 * Link: http://github.com/larakit
 * User: Alexey Berdnikov
 * Date: 04.05.16
 * Time: 11:25
 */

namespace Larakit\Makeup;

use Larakit\StaticFiles\Css;
use Larakit\StaticFiles\Js;

class MakeupBlock {

    protected $name;
    protected $params;
    protected $breakpoints = [];

    function __construct($name) {
        $this->name = $name;
        $this->css();
    }

    function setParams($params){
        $this->params = $params;
        return $this;
    }

    function js() {
        $f = '/!/static/blocks/' . $this->name . '/block.js';
        if(file_exists(public_path(trim($f, '/')))) {
            return $f;
        }

        return null;
    }

    function breakpoints(){
        return $this->breakpoints;
    }

    function breakpoint($size){
        $size = (int)$size;
        Manager::register_breakpoint($size);
        $this->breakpoints[$size] = $size;
        rsort($this->breakpoints);
    }

    function css() {
        $ret = [];
        $f   = '/!/static/blocks/' . $this->name . '/block.css';
        if(file_exists(public_path(trim($f, '/')))) {
            $ret[] = $f;
        }
        $suffix_breakpoints = '/!/static/blocks/' . $this->name . '/';
        $dir_breakpoints    = public_path(trim($suffix_breakpoints, '/'));
        if(file_exists($dir_breakpoints)) {
            foreach(\File::allFiles($dir_breakpoints) as $css) {
                $fn   = $css->getFilename();
                $size = (int) $fn;
                if($size) {
                    $this->breakpoint($size);
                    $ret[] = $suffix_breakpoints . $fn;
                }
            }
        }

        //        foreach($this->breakpoints as $breakpoint){
        //            $f = '/!/static/blocks/' . $this->name . '/breakpoints/'.$breakpoint.'.css';
        //            if(file_exists(public_path(trim($f, '/')))){
        //                $ret[] = $f;
        //            }
        //        }
        return $ret;
    }

    function __toString() {
        foreach($this->css() as $css) {
            Css::instance()->add($css);
        }
        $js = $this->js();
        if($js) {
            Js::instance()->add($js);
        }

        return (string) \View::make('!.makeup.blocks.' . $this->name, $this->params);
    }
}