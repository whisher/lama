<?php
namespace App\Controllers;

use \Controller,
    \Request,
    \Response,
    Users\Menu\MenuInterface;
    
class MenusController extends Controller
{
    protected $menu;
    public function __construct(MenuInterface $menu) 
    {
        $this->menu = $menu;
    }
    
    public function index() 
    {
        $menus = Request::input();
        if(!isset($menus['menus'])){
           return Response::make('Not Found', 404); 
        }
        $this->menu->set($menus['menus']);
        return $this->menu->get();
    }
    
}

