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
     * Handle a password reset 
     * 
     * @param  Array $data 
     * 
     * @return Array      
     */
    public function forgot($data);
    
    /**
     * Suspend a user
     * 
     * @param  int $id      
     * @param  array $data
     * 
     * @return Array          
     */
    public function suspend($id, $data);
    
    /**
     * Remove a users' suspension.
     * 
     * @param  int $id 
     * 
     * @return Array
     */
    public function unSuspend($id);
    
    /**
     * Ban an user
     * 
     * @param  int $id 
     * 
     * @return Array     
     */
    public function ban($id);
    
    /**
     * Attempt activation for the specified user
     * 
     * @param  int $id   
     * @param  string $code 
     * 
     * @return array       
     */
    public function activate($id, $code);
    
     /**
     * Process the password reset request
     * 
     * @param  int $id   
     * @param  string $code 
     * 
     * @return Array
     */
    public function resetPassword($id, $code);
    
    /**
     * Attempt Login 
     * 
     * @param  Sentry $user
     * @param  boolean $remember
     * 
     * @return array       
     */
    public function login($user, $remember);
    
    
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
    
    public function generatePassword($length,$strength);
    
}
