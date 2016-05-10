<?php
/**
 * Created by Larakit.
 * Link: http://github.com/larakit
 * User: Alexey Berdnikov
 * Date: 04.05.16
 * Time: 16:37
 */

namespace Larakit\Makeup;

class MakeupPage {
    protected $name;

    function __construct($name) {
        $this->name = $name;
        $this->body = \HtmlBody::setContent('');
    }

    function &body(){
        return $this->body;
    }

}