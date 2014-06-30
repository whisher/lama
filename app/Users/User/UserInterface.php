<?php namespace Users\User;

 interface UserInterface {

    /**
     * Store a newly created resource in storage.
     *
     * @return json
     */
    public function store($data);

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return json
     */
    public function update($id,$data);
    
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return json
     */
    public function account($id,$data);
    
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return json
     */
    public function password($id,$data);

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return json
     */
    public function destroy($id);

    /**
     * Return a specific user from the given id
     * 
     * @param  integer $id
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
