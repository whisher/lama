<?php namespace Users\User;

use \Config;

use Cartalyst\Sentry\Sentry;

class SentryUser implements UserInterface {

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
    public function store($data) 
    {
        $result = array('success' => 0);
        try {
            //Attempt to register the user. 
            $user = $this->sentry->register(
                    array(
                'email' => e($data['email']),
                'password' => e($data['password']),
                'fullname' => e($data['fullname']),
                'username' => e($data['username'])), Config::get('lama.activatedafterregister'));
            //success!
            $result['success'] = 1;
            $result['user'] = array(
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'fullname' => $user->getFullname(),
                'username' => $user->getUsername(),
                'groups' => array('Users'));
            $userGroup = $this->sentry->getGroupProvider()->findByName('Users');
            // Assign the groups to the users
            $user->addGroup($userGroup);
            // Do login
            if (Config::get('lama.loggedafterregister')) {
                $this->sentry->login($user, true);
            }
        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $result['error'] = trans('user.loginreq');
        } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
            $result['error'] = trans('user.exists');
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $result['error'] = trans('user.loginreq');
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $result['error'] = trans('user.notfound');
        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            $result['error'] = trans('user.notactivated');
        } catch (\Illuminate\Database\QueryException $e) {
            $result['error'] = trans('user.querror');
        } catch (\Exception $e) {
            $result['error'] = trans('user.generror');
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
    public function all() {
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
