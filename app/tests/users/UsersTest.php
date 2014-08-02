<?php

class UsersTest extends TestCase {

    protected $cookie;
    public function tearDown()
    {
        parent::tearDown();
    }
    
    public function setUp() {
        parent::setUp();
        $this->cookie = $this->_getCookieValue();
        
    }

    protected function _getCookieValue()
    {
        $crawler = $this->client->request('GET', '/');
        $text = $crawler->filter('body > div > script')->eq(0)->text();
        $chunks1 = explode("\n", trim($text));
        $chunks2 = explode("=", trim($chunks1[1]));
        return rtrim($chunks2[2], ';"');
    }
    
    public function _set404($method,$uri) 
    {
        $this->client->setServerParameter('HTTP_X-Requested-With', 'XMLHttpRequest');
        $crawler = $this->call($method, $uri);
        $this->assertResponseStatus(404);
    }
    
    public function _set200($method,$uri,$parameters=array()) 
    {
        $_COOKIE['XSRF-TOKEN'] = $this->cookie;
        $this->client->setServerParameter('HTTP_X-Requested-With', 'XMLHttpRequest');
        $this->client->setServerParameter('HTTP_X-XSRF-TOKEN', $_COOKIE['XSRF-TOKEN']);
        $response = $this->call($method, $uri,$parameters);
        $this->assertResponseStatus(200);
        return $response;
    }
    
    public function _set401($method,$uri) 
    {
        $_COOKIE['XSRF-TOKEN'] = $this->cookie;
        $this->client->setServerParameter('HTTP_X-Requested-With', 'XMLHttpRequest');
        $this->client->setServerParameter('HTTP_X-XSRF-TOKEN', $_COOKIE['XSRF-TOKEN']);
        $response = $this->call($method, $uri);
        $this->assertResponseStatus(401);
    }
    
    public function _set403($method,$uri) 
    {
        $_COOKIE['XSRF-TOKEN'] = $this->cookie;
        $this->client->setServerParameter('HTTP_X-Requested-With', 'XMLHttpRequest');
        $this->client->setServerParameter('HTTP_X-XSRF-TOKEN', $_COOKIE['XSRF-TOKEN']);
        $response = $this->call($method, $uri);
        $this->assertResponseStatus(403);
    }
    
    public function _getSuccess($content) 
    {
       $json = str_replace(")]}',\n", '', $content);
       $native = json_decode($json);
       return $native->success;
    }
    
    public function testSignin404() 
    {
       $this->_set404('POST', '/api/v1/signin');
    }
    
    public function testSignin200Fail() 
    {
         $response = $this->_set200('POST', '/api/v1/signin',array('email'=>'user@user.com','password'=>'pippo'));
         $this->assertEquals(0, $this->_getSuccess($response->getContent()));
    }
    
    public function testSignin200Success() 
    {
         $response = $this->_set200('POST', '/api/v1/signin',array('email'=>'user@user.com','password'=>'sentryuser'));
         $this->assertEquals(1, $this->_getSuccess($response->getContent()));
    }
    
    public function testUserRegister404() 
    {
        $this->_set404('POST', '/api/v1/user');
    }
    
    public function testUserRegister200() 
    {
        $this->_set200('POST', '/api/v1/user');
    }
    
    public function testUserCreate404() 
    {
        $this->_set404('POST', '/api/v1/user/create');
    }
    
    public function testUserCreate401() 
    {
        $this->_set401('POST', '/api/v1/user/create');
    }
    
    public function testUserCreate403() 
    { 
        $this->beUser();
        $this->_set403('POST', '/api/v1/user/create');
    }
    
    public function testUserCreate200() 
    {
        $this->beAdmin();
        $response = $this->_set200('POST', '/api/v1/user/create');
        
    }
    
    public function testUserForgot404() 
    {
        $this->_set404('POST', '/api/v1/user/forgot');
    }
    
    public function testUserForgot200Fail() 
    {
         $response = $this->_set200('POST', '/api/v1/user/forgot',array('email'=>'test@test.com'));
         $this->assertEquals(0, $this->_getSuccess($response->getContent()));
    }
    
    public function testUserForgot200Success() 
    {
        $response = $this->_set200('POST', '/api/v1/forgot',array('email'=>$this->userEmail));
        $this->assertEquals(1, $this->_getSuccess($response->getContent()));
    }
}
