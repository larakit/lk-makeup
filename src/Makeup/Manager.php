<?php
namespace Larakit\Makeup;

use Larakit\Helper\HelperFile;

class Manager {

    static           $pages       = [];
    static           $blocks      = [];
    static           $breakpoints = [];
    static           $lorempixel  = [];
    static protected $prefix;

    /**
     * @return mixed
     */
    public static function getUrl($sub = null) {
        return '/'.self::$prefix . DIRECTORY_SEPARATOR . $sub;
    }

    public static function getPrefix() {
        return self::$prefix;
    }

    public static function getPath($sub = null) {
        return public_path(self::$prefix . DIRECTORY_SEPARATOR . $sub);
    }

    /**
     * @param mixed $dir
     */
    public static function setPrefix($prefix) {
        self::$prefix = trim(HelperFile::normalizeFilePath($prefix), '/');
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
     *
     * @param $breakpoint
     */
    static function register_breakpoint($breakpoint) {
        $breakpoint          = (int) $breakpoint;
        self::$breakpoints[] = $breakpoint;
        self::$breakpoints   = array_unique(self::$breakpoints);
        rsort(self::$breakpoints);
    }

    /**
     * @param $name
     *
     * @return MakeupBlock
     */
    static function block($name) {
        if(!isset(self::$blocks[$name])) {
            self::$blocks[$name] = new MakeupBlock($name);
        }

        return self::$blocks[$name];
    }
}