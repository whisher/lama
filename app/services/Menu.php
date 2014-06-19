<?php
namespace App\Services;

use \URL;

class Menu {

    protected static $tabs = array(
        array(
            'label' => 'menu.home',
            'route' => 'base.index.index',
        ),
        array(
            'label' => 'menu.user',
            'route' => 'base.user.index'
        )
    );

    public static function all() {
        return static::$tabs;
    }

}