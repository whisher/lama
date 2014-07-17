<?php

/**
 * Class TestCase
 */
class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    

    /**
     * @var string
     */
    protected $userEmail = 'user@user.com';

    /**
     * @var string
     */
    protected $adminEmail = 'admin@admin.com';

    /**
     * Creates the application.
     *
     * @return Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        return require __DIR__ . '/../../bootstrap/start.php';
    }

    /**
     * Set up function for all tests
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->setUpDb();
        // To test auth, we must re-enable filters on the routes
        // By default, filters are disabled in testing
        Route::enableFilters();
    }

    /**
     * Set up the database for tests
     *
     */
    public function setUpDb()
    {
        Artisan::call('migrate', array('--package'=>'cartalyst/sentry'));
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }
    
     /**
     * Impersonate a guest
     *
     */
    public function beGuest()
    {
        Sentry::logout();
        Session::flush();
    }
    
    /**
     * Impersonate a user
     *
     */
    public function beUser()
    {
        $user = Sentry::findUserByLogin($this->userEmail);
        Sentry::setUser($user);
        Session::put('user', $user);
       
    }

    /**
     * Impersonate an admin
     *
     */
    public function beAdmin()
    {
        $admin = Sentry::findUserByLogin($this->adminEmail);
        Sentry::setUser($admin);
        Session::put('user', $user);
    }
    
    
    /**
     * Tear down the database for tests
     *
     */
    public function teardownDb()
    {
        Artisan::call('migrate:reset');
    }

    /**
     * Tear down function for all tests
     *
     */
    public function teardown()
    {
        Sentry::logout();
        Session::flush();
    }
    
   

    
}
