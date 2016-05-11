<?php
namespace Larakit\Makeup;

class Manager {
    static $pages       = [];
    static $blocks      = [];
    static $breakpoints = [];
    static $lorempixel  = [];

    static function namespace_block($code) {
        return '-' . $code;
    }

    /**
     * @param $name
     *
     * @return MakeupPage
     */
    static function page($name) {
        if(!isset(self::$pages[$name])) {
            self::$pages[$name] = new MakeupPage($name);
        }
        return self::$pages[$name];
    }

    /**
     * Регистрация брейкпоинта
     * @param $breakpoint
     */
    static function register_breakpoint($breakpoint) {
        $breakpoint = (int)$breakpoint;
        self::$breakpoints[] = $breakpoint;
        self::$breakpoints = array_unique(self::$breakpoints);
        rsort(self::$breakpoints);
    }

    /**
     * @param $name
     *
     * @return Block
     */
    static function block($name) {
        if(!isset(self::$blocks[$name])) {
            self::$blocks[$name] = new MakeupBlock($name);
        }
        return self::$blocks[$name];
    }
}