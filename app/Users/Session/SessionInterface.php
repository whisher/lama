<?php namespace Users\Session;

 interface SessionInterface {

    /**
     * Try to authenticate an user.
     *
     * @return Array
     */
    public function store($data);

    /**
     * Logout an user
     *
     * @return no return value
     */
    public function destroy();
}