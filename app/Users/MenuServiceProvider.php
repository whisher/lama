<?php namespace Users;

use Illuminate\Support\ServiceProvider;
use Users\Menu\SentryMenu;



class MenuServiceProvider extends ServiceProvider {

    /**
     * Register the binding
     */
    public function register() {
        $app = $this->app;
        $app->bind('Users\Menu\MenuInterface', function($app) {
                    return new SentryMenu(
                                    $app['sentry']
                    );
                });
    }

}