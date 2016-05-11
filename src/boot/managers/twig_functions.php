<?php

/**
 * @return \Faker\Generator
 */
function faker_rus() {
    return Faker\Factory::create('ru_RU');
}

\Larakit\Twig::register_function('faker_digit', function () {
    return faker_rus()->randomDigit;
});
\Larakit\Twig::register_function('faker_name', function () {
    return faker_rus()->name;
});
\Larakit\Twig::register_function('faker_address', function () {
    return faker_rus()->address;
});
\Larakit\Twig::register_function('faker_word', function () {
    return faker_rus()->word;
});
\Larakit\Twig::register_function('faker_sentence', function ($nbWords = 6, $variableNbWords = true) {
    return faker_rus()->sentence($nbWords, $variableNbWords);
});
\Larakit\Twig::register_function('faker_paragraph', function ($nbSentences = 3, $variableNbSentences = true) {
    return faker_rus()->paragraph($nbSentences, $variableNbSentences);
});
\Larakit\Twig::register_function('faker_text', function ($maxNbChars = 200) {
    return faker_rus()->text($maxNbChars);
});
\Larakit\Twig::register_function('faker_phone', function () {
    return faker_rus()->phoneNumber;
});
\Larakit\Twig::register_function('faker_company', function () {
    return faker_rus()->company;
});
\Larakit\Twig::register_function('faker_date', function ($start = '-30 years') {
    return faker_rus()->dateTimeBetween($start);
});
\Larakit\Twig::register_function('faker_email', function () {
    return faker_rus()->email;
});
\Larakit\Twig::register_function('faker_domain', function () {
    return faker_rus()->domainName;
});
\Larakit\Twig::register_function('faker_ip', function () {
    return faker_rus()->ipv4;
});
\Larakit\Twig::register_function('faker_user_agent', function () {
    return faker_rus()->userAgent;
});
\Larakit\Twig::register_function('faker_image', function ($width = 640, $height = 480, $cat = 'business') {
    if(!isset(\Larakit\Makeup\Manager::$lorempixel[$width . 'x' . $height])) {
        \Larakit\Makeup\Manager::$lorempixel[$width . 'x' . $height] = 0;
    }

    return URL::route('lorempixel', [
        'w'      => $width,
        'h'      => $height,
        'cat'    => $cat,
        'number' => ++\Larakit\Makeup\Manager::$lorempixel[$width . 'x' . $height],
    ]);
});
\Larakit\Twig::register_function('makeup_pages', function ($width = 640, $height = 480, $cat = null) {
    return \Larakit\Makeup\Manager::$pages;
});
\Larakit\Twig::register_function('makeup_blocks', function ($width = 640, $height = 480, $cat = null) {
    return \Larakit\Makeup\Manager::$blocks;
});
\Larakit\Twig::register_function('makeup_block', function ($name, $params = []) {
    return \Larakit\Makeup\Manager::block($name)->setParams($params).'';
});
View::composer('lk-makeup::!.layouts.page', function ($view) {
    $view->with('theme', Request::input('theme'));
    $view->with('breakpoint', Request::input('breakpoint'));
    $view->with('path', Request::path());
});
View::composer('lk-makeup::!.layouts.block', function ($view) {
    $view->with('theme', Request::input('theme'));
    $view->with('breakpoint', Request::input('breakpoint'));
    $view->with('path', Request::path());
});
View::composer('lk-makeup::!.partials.dispatcher', function ($view) {
    $view->with('theme', Request::input('theme'));
    $view->with('breakpoint', Request::input('breakpoint'));
    $view->with('path', Request::path());
    $view->with('blocks', \Larakit\Makeup\Manager::$blocks);
    $view->with('themes', ['default'=>'default']+\Larakit\Page\PageTheme::getThemes());
    $view->with('pages', \Larakit\Makeup\Manager::$pages);
    $breakpoints            = [];
    $breakpoints[0]['text'] = 'FULLPAGE';
    $prev                   = 0;
    $max                    = 0;
    $b                      = 0;
    foreach(\Larakit\Makeup\Manager::$breakpoints as $b) {
        if(!$max) {
            $max = $b;
        }
        $breakpoints[$b] = [];
        if($prev) {
            $breakpoints[$prev]['next'] = $b;
        }
        $breakpoints[$b]['prev'] = $prev;
        $prev                    = $b;
    }
    $breakpoints[0]['title']    = 'больше ' . $max . 'px';
    $breakpoints[$prev]['next'] = $b;
    foreach($breakpoints as $b => $val) {
        $next = \Illuminate\Support\Arr::get($val, 'next');
        if($b) {
            $breakpoints[$b]['title'] = ($next == $b) ? 'меньше ' . $b . 'px' : ' от ' . $next . 'px до ' . $b . 'px';
            $breakpoints[$b]['text']  = $b . 'px';
        }
    }
    $view->with('breakpoints', $breakpoints);
});
