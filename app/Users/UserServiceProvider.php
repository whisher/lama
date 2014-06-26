<?php namespace Users;

use Illuminate\Support\ServiceProvider;
use Cartalyst\Sentry\Sentry;
use Users\Session\SentrySession;
use Users\User\SentryUser;

class UserServiceProvider extends ServiceProvider {

    /**
     * Register the binding
     */
    public function register() {
        $app = $this->app;
        $app->bind('Users\Session\SessionInterface', function($app) {
                    return new SentrySession(
                            $app['sentry']);
                });

        $app->bind('Users\User\UserInterface', function($app) {
                    return new SentryUser(
                                    $app['sentry']
                    );
                });
    }

}