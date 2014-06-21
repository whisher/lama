<?php  
namespace App\Controllers;

use \BaseController,
    \Sentry,
    \View; 

class HomeController extends BaseController
{
    public $layout = 'layouts.home';
    
    public function index()
    { 
        $userData = array();
        if (Sentry::check()){
            $user = Sentry::getUser();
            $groups = array();
            foreach($user->getGroups() as $group){
                $groups[] = $group->name;
            }
            $userData = array('id'=>$user->id,'email'=>$user->email,'fullname'=>$user->fullname,'username'=>$user->username,'groups'=>$groups);
        }
        $token = csrf_token();
        $this->layout->content = View::make('home.content')->with('data', array('token'=>$token,'user'=> json_encode($userData) ));
    }
    
}