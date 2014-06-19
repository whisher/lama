<?php  
namespace App\Controllers;

use \View; 

class HomeController extends \BaseController
{
    
    public function index()
    { 
        $this->layout->content = View::make('home.content');
    }
    
 }