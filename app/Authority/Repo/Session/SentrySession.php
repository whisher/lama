<?php namespace Authority\Repo\Session;

use Cartalyst\Sentry\Sentry;
use Authority\Repo\RepoAbstract;

class SentrySession extends RepoAbstract implements SessionInterface {

    protected $sentry;
    protected $throttleProvider;

    public function __construct(Sentry $sentry) {
        $this->sentry = $sentry;

        // Get the Throttle Provider
        $this->throttleProvider = $this->sentry->getThrottleProvider();

        // Enable the Throttling Feature
        $this->throttleProvider->enable();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($data) {
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
        catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            $time = $throttle->getSuspensionTime();
            $result['error'] = trans('session.suspended');
        } catch (\Cartalyst\Sentry\Throttling\UserBannedException $e) {
            $result['error'] = trans('session.banned');
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $result['error'] = trans('session.invalid');
        } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
           $result['error'] = trans('session.notactive');
        }
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy() {
        $this->sentry->logout();
    }

}