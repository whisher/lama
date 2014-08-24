<?php
namespace App\Controllers;

use \Controller,
    \Input,
    \Response;
    
use Users\Group\GroupInterface;


class GroupsController extends Controller{

    protected $group;
   
    public function __construct(GroupInterface $group) 
    {
        $this->group = $group;
        
    }

    /**
     * List of groups.
     *
     * @return json
     */
    public function index() 
    {
        $groups = $this->group->all();
        return Response::json($groups, 200);
    }

}

