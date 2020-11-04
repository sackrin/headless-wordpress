<?php

namespace App\Page;

class Provider {

    public static function init() {
        self::routes();
        self::listeners();
    }

    protected static function routes() {

    }

    protected static function listeners() {
        \App\Page\Model\Page::init();
        \App\Page\Listener\View::init();
    }

}