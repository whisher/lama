<?php namespace Users;

use Illuminate\Support\ServiceProvider;
use Users\Form\Signin\SigninForm;
use Users\Form\Signin\SigninFormLaravelValidator;
use Users\Form\Register\RegisterForm;
use Users\Form\Register\RegisterFormLaravelValidator;

class FormServiceProvider extends ServiceProvider {

    /**
     * Register the binding
     *
     * @return void
     */
    public function register() {
        $app = $this->app;
        $app->bind('Users\Form\Signin\SigninForm', function($app) {
            return new SigninForm(new SigninFormLaravelValidator($app['validator']));
        });

        // Bind the Register Form
        $app->bind('Users\Form\Register\RegisterForm', function($app) {
                    return new RegisterForm(
                                    new RegisterFormLaravelValidator($app['validator'])
                    );
                });
    }

}