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
        $result = array('success' => false);
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
            $result['success'] = true;
            $result['data'] = array('userId' => $user->id, 'email' => $user->email);
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            // Sometimes a user is found, however hashed credentials do
            // not match. Therefore a user technically doesn't exist
            // by those credentials. Check the error message returned
            // for more information.
            $result['message'] = trans('session.invalid');
        } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            $url = route('resendActivationForm');
            $result['message'] = trans('session.notactive', array('url' => $url));
        }
        // The following is only required if throttle is enabled
        catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            $time = $throttle->getSuspensionTime();
            $result['message'] = trans('session.suspended');
        } catch (\Cartalyst\Sentry\Throttling\UserBannedException $e) {
            $result['message'] = trans('session.banned');
        }
        //Login was succesful.  
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