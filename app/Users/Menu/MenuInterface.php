<?php namespace Users\Menu;

interface MenuInterface
{
    /**
     * Get current user menu
     * 
     * @param  Array $menus 
     * 
     * @return Array      
     */
    public function get();
    
    public function set(array $menus); 
}