<?php namespace Users\Session;

use Cartalyst\Sentry\Sentry;

class SentrySession implements SessionInterface {

    protected $sentry;
    protected $throttleProvider;

    public function __construct(Sentry $sentry) 
    {
        $this->sentry = $sentry;
        $this->throttleProvider = $this->sentry->getThrottleProvider();
        $this->throttleProvider->enable();
    }

    /**
     * Try to authenticate an user
     *
     * @return Array
     */
    public function store($data) 
    {
        $result = array('success' => 0);
        try {
            
            //Check for suspension or banned status
            $user = $this->sentry->getUserProvider()->findByLogin(e($data['email']));
            $throttle = $this->throttleProvider->findByUserId($user->id);
            $throttle->check();

            // Set login credentials
            $credentials = array(
                'email' => e($data['email']),
                'password' => e($data['password'])
            );

            // Try to authenticate the user
            if (isset($data['remember'])) {
                $user = $this->sentry->authenticateAndRemember($credentials);
            } else {
                $user = $this->sentry->authenticate($credentials, false);
            }
            $groups = array();
            foreach($user->getGroups() as $group){
                $groups[] = $group->name;
            }
            $result['success'] = 1;
            
            $result['user'] = array(
                'id' => $user->getId(), 
                'email' => $user->getEmail(),
                'fullname' => $user->getFullname(), 
                'username' => $user->getUsername(),
                'groups'=>$groups);
        } 
        catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $result['error'] = trans('session.loginrequired');
        } catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $result['error'] = trans('session.passwordrequired');
        } catch (\Cartalyst\Sentry\Users\WrongPasswordException $e) {
            $result['error'] = trans('session.wrongpassword');
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $result['error'] = trans('session.notfound');
        } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            $result['error'] = trans('session.notactive');
        } catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            $time = $throttle->getSuspensionTime();
            $result['error'] = trans('session.suspended');
        } catch (\Cartalyst\Sentry\Throttling\UserBannedException $e) {
            $result['error'] = trans('session.banned');
        } catch (\Exception $e) {
            $result['error'] = trans('user.generror');
        }
        return $result;
    }

    /**
     * Logout an user
     *
     * @return no return value
     */
    public function destroy() 
    {
        $this->sentry->logout();
    }

}
