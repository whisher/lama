<?php namespace Users\User;

 interface UserInterface {

     /**
     * Register an user.
     * 
     * @param  array  $data
     * 
     * @return array
     */
    public function create($data);
    
    /**
     * Register an user.
     * 
     * @param  array  $data
     * 
     * @return array
     */
    public function register($data);

    /**
     * Update the user account.
     *
     * @param  int  $id
     * @param  array  $data
     * 
     * @return Array
     */
    public function edit($id,$data);
    
    /**
     * Update the user account.
     *
     * @param  int  $id
     * @param  array  $data
     * 
     * @return Array
     */
    public function account($id,$data);
    
    /**
     * Update the user password.
     *
     * @param  int  $id
     * @param  array  $data
     * 
     * @return Array
     */
    public function password($id,$data);

    /**
     * Remove the user.
     *
     * @param  int  $id
     * 
     * @return Boolean
     */
    public function destroy($id);

    /**
     * Return a specific user from the given id
     * 
     * @param  integer $id
     * 
     * @return User
     */
    public function byId($id);

    /**
     * Return all the registered users
     *
     * @return stdObject Collection of users
     */
    public function all();
}
