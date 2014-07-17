<?php

/**
 * Class UserControllerTest
 */
class UserControllerTest extends TestCase {
    
    public $mockUser;
    public $mockRegisterForm;
    public $mockUpdateForm;
    
    public function setUp() 
    {
        // Call the parent setup method
        parent::setUp();
        $this->mockUser = Mockery::mock('SentryUser');
        
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
    * Test the two basic user types
    *
    */
    public function testBasicUserTypes() 
    {
        $this->assertTrue(Sentry::getUser() == NULL, 'User should not be logged in initially.');
        
        $admin = Sentry::findUserByLogin($this->adminEmail);
        $this->assertTrue($admin != NULL, 'Admin account not found.');

        $user = Sentry::findUserByLogin($this->userEmail);
        $this->assertTrue($user != NULL, 'User account not found.');

        Sentry::setUser($user);
        $this->assertTrue(Sentry::check(),'User not logged in.');

        Sentry::setUser($admin);
        $this->assertTrue(Sentry::check(),'Admin not logged in.');

        Sentry::logout();
    }
    
    public function testBasicExample() {

        $crawler = $this->client->request('GET', '/');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testUser404() {

        $crawler = $this->client->request('GET', '/api/v1/user');

        $this->assertResponseStatus(404);
    }
    
    protected function getCookieValue() 
    {
        $crawler = $this->client->request('GET', '/');
        $text = $crawler->filter('body > div > script')->eq(0)->text();
        $chunks1 = explode("\n", trim($text));
        $chunks2 = explode("=", trim($chunks1[1]));
        return rtrim($chunks2[2],';"');
    }
    
    public function testUser401() {
        $_COOKIE['XSRF-TOKEN'] = $this->getCookieValue();
        $this->client->setServerParameter('HTTP_X-Requested-With', 'XMLHttpRequest');
        $this->client->setServerParameter('HTTP_X-XSRF-TOKEN', $_COOKIE['XSRF-TOKEN']);
        $crawler = $this->client->request('GET', '/api/v1/user');
        $this->assertResponseStatus(401);
    }
}


  
