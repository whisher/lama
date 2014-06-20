<?php  
namespace App\Controllers;

use \BaseController,
    \View; 

class HomeController extends BaseController
{
    public $layout = 'layouts.home';
    
    public function index()
    { 
        $token = csrf_token();
        $this->layout->content = View::make('home.content')->with('data', array('token'=>$token));
    }
    
}