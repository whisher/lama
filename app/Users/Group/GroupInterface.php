<?php namespace Users\Group;

interface GroupInterface {

	
	/**
	 * Return a specific user by a given id
	 * 
	 * @param  integer $id
	 * @return User
	 */
	public function byId($id);

	/**
	 * Return a specific user by a given name
	 * 
	 * @param  string $name
	 * @return User
	 */
	public function byName($name);

	/**
	 * Return all the registered users
	 *
	 * @return stdObject Collection of users
	 */
	public function all();

}
