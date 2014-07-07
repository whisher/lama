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
     *  Create an user.
     *
     * @return Array
     */
    public function create($data) 
    {
        $result = array('success' => 0);
        try {
            //Attempt to register the user. 
            $user = $this->sentry->createUser(
                    array(
                'email' => e($data['email']),
                'password' => e($data['password']),
                'fullname' => e($data['fullname']),
                'username' => e($data['username']),
                'activated'=>true));
            //success!
            $result['success'] = 1;
            $groups = array();
            foreach($data['groups'] as $groupId){
                $userGroup = $this->sentry->getGroupProvider()->findById($groupId);
                // Assign the groups to the users
                $user->addGroup($userGroup);
                $groups[] = $userGroup->name;
            }
            
            $result['user'] = array(
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'fullname' => $user->getFullname(),
                'username' => $user->getUsername(),
                'groups' => $groups);
        } 
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
             $result['error'] = trans('user.loginreq');
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
             $result['error'] = trans('user.passwordreq');;
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            $result['error'] = trans('user.exists');
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            $result['error'] = trans('user.notfoundgroup');
        }
        catch (\Illuminate\Database\QueryException $e) {
            $result['error'] = trans('user.querror');
        } catch (\Exception $e) {
            $result['error'] = trans('user.generror');
        }
        return $result;
    }
    
    /**
     *  Register an user.
     *
     * @return Array
     */
    public function register($data) 
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
        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $result['error'] = trans('user.loginreq');
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $result['error'] = trans('user.notfound');
        } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            $result['error'] = trans('user.notactivated');
        } catch (\Illuminate\Database\QueryException $e) {
            $result['error'] = trans('user.querror');
        } catch (\Exception $e) {
            $result['error'] = trans('user.generror');
        }
        return $result;
    }

    /**
     * Update user.
     *
     * @return Array
     */
    public function edit($id,$data) 
    {
        $result = array('success' => 0);
        try { 
            $user = $this->sentry->findUserById($id);
            $fullname = e($data['fullname']);
            $email = e($data['email']);
            $username = e($data['username']);
            if($username !== $user->username ){
                $user->username = $username;
            }
            if($email !== $user->email ){
                $user->email = $email;
            }
            $user->fullname = $fullname;
            $user->save();
            
            $groups = $user->getGroups();
           
            foreach($groups as $group){
                $user->removeGroup($group);
            }
            
            foreach($data['groups'] as $key => $value){
                $userGroup = $this->sentry->getGroupProvider()->findById($key);
                $user->addGroup($userGroup);
                $groups[] = $userGroup->name;
            }
           
            $result['success'] = 1;
            $result['user'] = array(
                'id' => $user->getId(),
                'email' => $user->email,
                'fullname' => $user->fullname,
                'username' => $user->username,
                'groups'=>$groups
            );
            
        } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
            $result['error'] = trans('user.exists');
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $result['error'] = trans('user.notfound');
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            $result['error'] = trans('user.notfoundgroup');
        }catch (\Illuminate\Database\QueryException $e) {
            $result['error'] = trans('user.exists');
        }catch (\Exception $e) {
            $result['error'] = trans('user.generror');
        }
        return $result;
    }
    
    /**
     * Update account.
     *
     * @return Array
     */
    public function account($id,$data) 
    {
        $result = array('success' => 0);
        try {
            $user = $this->sentry->findUserById($id);
            $fullname = e($data['fullname']);
            $email = e($data['email']);
            $username = e($data['username']);
            if($username !== $user->username ){
                $user->username = $username;
            }
            if($email !== $user->email ){
                $user->email = $email;
            }
            $user->fullname = $fullname;
            $user->save();
            $result['success'] = 1;
            $result['user'] = array(
                'id' => $user->getId(),
                'email' => $user->email,
                'fullname' => $user->fullname,
                'username' => $user->username,
            );
            
        } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
            $result['error'] = trans('user.exists');
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $result['error'] = trans('user.notfound');
        } catch (\Illuminate\Database\QueryException $e) {
            $result['error'] = trans('user.exists');
        }catch (\Exception $e) {
            $result['error'] = trans('user.generror');
        }
        return $result;
    }
    
    /**
     * Update password.
     *
     * @return Array
     */
    public function password($id,$data) 
    {
        $result = array('success' => 0);
        try {
            $user = $this->sentry->findUserById($id);
            if ($user->checkHash(e($data['old_password']), $user->getPassword())){
                $user->password = e($data['password']);
                $user->save();
                $result['success'] = 1;
                $result['user'] = array(
                    'id' => $user->getId(),
                    'email' => $user->email,
                    'fullname' => $user->fullname,
                    'username' => $user->username
                );
            }
            else {
                $result['error'] = trans('user.oldpassword');
            }        
        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e){
            $result['error'] = trans('loginreq');
	}
        catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
            $result['error'] = trans('user.exists');
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $result['error'] = trans('user.notfound');
        } catch (\Illuminate\Database\QueryException $e) {
            $result['error'] = trans('user.exists');
        }catch (\Exception $e) {
            $result['error'] = trans('user.generror');
        }
        return $result;
    }
    
    
    /**
     * Suspend a user
     * @param  int $id      
     * @param  int $minutes 
     * @return Array          
     */
    public function suspend($id, $data) {
        $result = array('success' => 0);
        try {
            // Find the user using the user id
            $throttle = $this->sentry->findThrottlerByUserId($id);
            //Set suspension time
            $throttle->setSuspensionTime($data['minutes']);
            // Suspend the user
            $throttle->suspend();
            $result['success'] = 1;
           
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $result['message'] = trans('users.notfound');
        }
        return $result;
    }

    /**
     * Return a specific user from the given id
     * 
     * @param  integer $id
     * 
     * @return User
     */
    public function byId($id) {
        try {
            $user = $this->sentry->findUserById($id);
            $user->groups = $user->getGroups();
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
                $user->active = true;
                $user->status = trans('user.active');
            } else {
                $user->active = false;
                $user->status = trans('user.noactive');
            }
            //Pull Suspension & Ban info for this user
            $throttle = $this->throttleProvider->findByUserId($user->id);
            //Check for suspension
            if ($throttle->isSuspended()) {
                // User is Suspended
                $user->active = false;
                $user->status = trans('user.noactive');
            }
            //Check for ban
            if ($throttle->isBanned()) {
                // User is Banned
                $user->active = false;
                $user->status = trans('user.banned');
            }
            $user->groups = $user->getGroups();
        }
        return $users;
    }
    
    /**
     * Remove an user.
     *
     * @param  int  $id
     * 
     * @return Boolean
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

}
