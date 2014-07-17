<?php
namespace App\Controllers;

use \Controller,
    \Request,
    \Response,
    Users\Menu\MenuInterface;
    
class MenuController extends Controller
{
    protected $menu;
    public function __construct(MenuInterface $menu) 
    {
        $this->menu = $menu;
        $menus = Request::input();
        $this->menu->set($menus['menus']);
    }
    
    public function index() 
    {
       return $this->menu->get();
    }
    
}

