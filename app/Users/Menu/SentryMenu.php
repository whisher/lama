<?php namespace Users\Menu;

use \Cartalyst\Sentry\Sentry;

class SentryMenu implements MenuInterface {

    protected $sentry;
    protected $menus;

    public function __construct(Sentry $sentry) 
    {
        $this->sentry = $sentry;
    }
    /**
     * Get current user menu
     * 
     * @param  Array $menus 
     * 
     * @return Array      
     */
    public function get()
    {
       $userMenu = array();
       foreach ($this->menus as $menu){
           $tmp = json_decode($menu, true);
           if(is_null($tmp['permission']) || $this->hasAccess($tmp['permission'])){
              $userMenu[] = $tmp;  
           }
       } 
       return $userMenu;
    }
    
    public function set(array $menus)
    {
        $this->menus = $menus;
    }
    
    /**
     * Check current user permission
     * 
     * @param  String $permission 
     * 
     * @return bool      
     */
    protected function hasAccess($permission)
    {
        if ($this->sentry->check()) {
            $user = $this->sentry->getUser();
            return $user->hasAccess($permission);
        }
        return false;
    }
    
}