<?php namespace Authority\Repo\User;

use Mail;
use Cartalyst\Sentry\Sentry;
use Authority\Repo\RepoAbstract;

class SentryUser extends RepoAbstract implements UserInterface {

    protected $sentry;

    /**
     * Construct a new SentryUser Object
     */
    public function __construct(Sentry $sentry) 
    {
        $this->sentry = $sentry;
        $this->throttleProvider = $this->sentry->getThrottleProvider();
        $this->throttleProvider->enable();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($data) {
        $result = array('success' => false);
        try {
            //Attempt to register the user. 
            $user = $this->sentry->register(array('email' => e($data['email']), 'password' => e($data['password'])));

            //success!
            $result['success'] = true;
            $result['message'] = trans('user.created');
            $result['mailData']['activationCode'] = $user->getActivationCode();
            $result['mailData']['userId'] = $user->getId();
            $result['mailData']['email'] = e($data['email']);
            $userGroup = $this->sentry->getGroupProvider()->findByName('Users');
		

	    // Assign the groups to the users
	    $user->addGroup($userGroup);
            
        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $result['message'] = trans('user.loginreq');
        } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {

            $result['message'] = trans('user.exists');
        }

        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array $data
     * @return Response
     */
    public function update($data) {
        $result = array();
        try {
            // Find the user using the user id
            $user = $this->sentry->findUserById($data['id']);

            // Update the user details
            $user->first_name = e($data['firstName']);
            $user->last_name = e($data['lastName']);

            // Only Admins should be able to change group memberships. 
            $operator = $this->sentry->getUser();
            if ($operator->hasAccess('admin')) {
                // Update group memberships
                $allGroups = $this->sentry->getGroupProvider()->findAll();
                foreach ($allGroups as $group) {
                    if (isset($data['groups'][$group->id])) {
                        //The user should be added to this group
                        $user->addGroup($group);
                    } else {
                        // The user should be removed from this group
                        $user->removeGroup($group);
                    }
                }
            }

            // Update the user
            if ($user->save()) {
                // User information was updated
                $result['success'] = true;
                $result['message'] = trans('users.updated');
            } else {
                // User information was not updated
                $result['success'] = false;
                $result['message'] = trans('users.notupdated');
            }
        } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
            $result['success'] = false;
            $result['message'] = trans('users.exists');
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $result['success'] = false;
            $result['message'] = trans('users.notfound');
        }

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        try {
            // Find the user using the user id
            $user = $this->sentry->findUserById($id);

            // Delete the user
            $user->delete();
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return false;
        }
        return true;
    }

    
    /**
     * Return a specific user from the given id
     * 
     * @param  integer $id
     * @return User
     */
    public function byId($id) {
        try {
            $user = $this->sentry->findUserById($id);
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return false;
        }
        return $user;
    }

    /**
     * Return all the registered users
     *
     * @return stdObject Collection of users
     */
    public function all() 
    {
        $users = $this->sentry->findAllUsers();

        foreach ($users as $user) {
            if ($user->isActivated()) {
                $user->status = "Active";
            } else {
                $user->status = "Not Active";
            }

            //Pull Suspension & Ban info for this user
            $throttle = $this->throttleProvider->findByUserId($user->id);

            //Check for suspension
            if ($throttle->isSuspended()) {
                // User is Suspended
                $user->status = "Suspended";
            }

            //Check for ban
            if ($throttle->isBanned()) {
                // User is Banned
                $user->status = "Banned";
            }
        }

        return $users;
    }

}
