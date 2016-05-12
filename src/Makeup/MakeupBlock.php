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

    function setParams($params) {
        $this->params = $params;

        return $this;
    }

    function js() {
        $f = Manager::getUrl('blocks/'.$this->name . '/block.js');
        if(file_exists(public_path(trim($f, '/')))) {
            return $f;
        }

        return null;
    }

    function css() {
        $ret = [];
        $prefix = 'blocks/'.$this->name.'/' ;
        if(file_exists(Manager::getPath($prefix . 'block.css'))) {
            $ret[] = Manager::getUrl($prefix . 'block.css');
        }
        $suffix_breakpoints = Manager::getUrl($prefix);
        $dir_breakpoints    = Manager::getPath($prefix);
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

        return $ret;
    }

    function breakpoints() {
        return $this->breakpoints;
    }

    function breakpoint($size) {
        $size = (int) $size;
        Manager::register_breakpoint($size);
        $this->breakpoints[$size] = $size;
        rsort($this->breakpoints);
    }

    function __toString() {
        try {
            \Larakit\StaticFiles\Manager::package('makeup-blocks')
                                        ->usePackage('common');
            foreach($this->css() as $css) {
                \Larakit\StaticFiles\Manager::package('makeup-blocks')
                    ->css($css);
            }
            $js = $this->js();
            if($js) {
                \Larakit\StaticFiles\Manager::package('app')
                                            ->js($js);
            }

            return (string) \View::make('larakit-makeup::blocks.' . $this->name . '.block', $this->params);
        }
        catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}