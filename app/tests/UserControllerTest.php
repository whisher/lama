<?php

/**
 * Class UserControllerTest
 */
class UserControllerTest extends TestCase {

    public function setUp() {
        
        // Call the parent setup method
        parent::setUp();

    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testUserControllerIndexAsGuest()
    {
        $response = $this->call('POST', URL::action('UserController@store'));
        $this->assertEquals('Hello World', $response->getContent());
    }
}