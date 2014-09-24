<?php

class UsersTest extends TestCase {

    protected $cookie;

    public function tearDown() {
        parent::tearDown();
    }

    public function setUp() {
        parent::setUp();
        $this->cookie = $this->_getCookieValue();
    }

    protected function _getCookieValue() {
        $crawler = $this->client->request('GET', '/');
        $text = $crawler->filter('body > div > script')->eq(0)->text();
        $chunks1 = explode("\n", trim($text));
        $chunks2 = explode("=", trim($chunks1[1]));
        return rtrim($chunks2[2], ';"');
    }

    public function _set401($method, $uri) {
        $_COOKIE['XSRF-TOKEN'] = $this->cookie;
        $this->client->setServerParameter('HTTP_X-Requested-With', 'XMLHttpRequest');
        $this->client->setServerParameter('HTTP_X-XSRF-TOKEN', $_COOKIE['XSRF-TOKEN']);
        $response = $this->call($method, $uri);
        $this->assertResponseStatus(401);
    }

    public function _set403($method, $uri) {
        $_COOKIE['XSRF-TOKEN'] = $this->cookie;
        $this->client->setServerParameter('HTTP_X-Requested-With', 'XMLHttpRequest');
        $this->client->setServerParameter('HTTP_X-XSRF-TOKEN', $_COOKIE['XSRF-TOKEN']);
        $response = $this->call($method, $uri);
        $this->assertResponseStatus(403);
    }
    
    public function _set404($method, $uri) {
        $this->client->setServerParameter('HTTP_X-Requested-With', 'XMLHttpRequest');
        $crawler = $this->call($method, $uri);
        $this->assertResponseStatus(404);
    }

    public function _set200($method, $uri, $parameters = array()) {
        $_COOKIE['XSRF-TOKEN'] = $this->cookie;
        $this->client->setServerParameter('HTTP_X-Requested-With', 'XMLHttpRequest');
        $this->client->setServerParameter('HTTP_X-XSRF-TOKEN', $_COOKIE['XSRF-TOKEN']);
        $response = $this->call($method, $uri, $parameters);
        $this->assertResponseStatus(200);
        return $response;
    }

    public function _getSuccess($content) {
        $json = str_replace(")]}',\n", '', $content);
        $native = json_decode($json);
        return $native->success;
    }

    public function _getData($content) {
        $json = str_replace(")]}',\n", '', $content);
        return json_decode($json, true);
    }

    // SessionsController@store 
    
    public function testSignin404() {
        $this->_set404('POST', '/api/v1/signin');
    }

    public function testSignin403() {
        $this->beUser();
        $this->_set403('POST', '/api/v1/signin');
    }
    
    public function testSignin200Fail() 
    {
         $response = $this->_set200('POST', '/api/v1/signin',array('email'=>'fake@fake.com','password'=>'fakeuser'));
         $this->assertSame(0, $this->_getSuccess($response->getContent()));
    }
    
    public function testSignin200Success() 
    {
         $response = $this->_set200('POST', '/api/v1/signin',array('email'=>'user@user.com','password'=>'sentryuser'));
         $this->assertSame(1, $this->_getSuccess($response->getContent()));
    }
   
    // UsersController@register 
   
    public function testUserRegister404() 
    {
        $this->_set404('POST', '/api/v1/users');
    }
    
    public function testUserRegister403() 
    {
        $this->beUser();
        $this->_set403('POST', '/api/v1/users');
    }
    
    public function testUserRegister200Fail() 
    {
        $response = $this->_set200('POST', '/api/v1/users',array('email'=>'user@user.com'));
        $this->assertSame(0, $this->_getSuccess($response->getContent()));
    }
    
    public function testUserRegister200Success() 
    {
        $response = $this->_set200('POST', '/api/v1/users',array('fullname'=>'user test','username'=>'usertest','email'=>'test@test.com','password'=>'testuser','password_confirmation'=>'testuser'));
        $this->assertSame(1, $this->_getSuccess($response->getContent()));
    }
    
    // UsersController@create 
    
    public function testUserCreate404() 
    {
        $this->_set404('POST', '/api/v1/users/create');
    }
    
    public function testUserCreate401() 
    {
        $this->_set401('POST', '/api/v1/users/create');
    }
    
    public function testUserCreate403() 
    { 
        $this->beUser();
        $this->_set403('POST', '/api/v1/users/create');
    }
    
    public function testUserCreate200Fail() 
    {
        $this->beAdmin();
        $response = $this->_set200('POST', '/api/v1/users/create',array('email'=>'user@user.com'));
        $this->assertSame(0, $this->_getSuccess($response->getContent()));
    }
    
    public function testUserCreate200Success() 
    {
        $this->beAdmin();
        $group = Sentry::findGroupByName('Users');
        $response = $this->_set200('POST', '/api/v1/users/create',array('fullname'=>'user test','username'=>'usertest','email'=>'test@test.com','password'=>'testuser','password_confirmation'=>'testuser','groups'=>array($group->id)));
        $this->assertSame(1, $this->_getSuccess($response->getContent()));
    }
    
    // UsersController@forgot
    
    public function testUserForgot404() 
    {
        $this->_set404('POST', '/api/v1/users/forgot');
    }
    
    public function testUserForgot200Fail() 
    {
         $response = $this->_set200('POST', '/api/v1/users/forgot',array('email'=>'noexistsmail@test.com'));
         $this->assertSame(0, $this->_getSuccess($response->getContent()));
    }
    
    public function testUserForgot200Success() 
    {
        $response = $this->_set200('POST', '/api/v1/users/forgot',array('email'=>$this->userEmail));
        $this->assertSame(1, $this->_getSuccess($response->getContent()));
    }
    
    // UsersController@index 
    
    public function testUsers404() 
    {
        $this->_set404('GET', '/api/v1/users');
    }
    
    public function testUsers403() 
    {   
        $this->beUser();
        $this->_set403('GET', '/api/v1/users');
    }
    
    public function testUsers200() 
    {
         $this->beAdmin();
         $response = $this->_set200('GET', '/api/v1/users');
         $data = $this->_getData($response->getContent());
         $this->assertSame(2, count($data));
    }
    
    // UsersController@show 
    
    public function testUserShow404() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set404('GET', '/api/v1/users/'.$user->id);
    }
    
    public function testUserShow401() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set401('GET', '/api/v1/users/'.$user->id);
    }
    
    public function testUserShow200() 
    {
         $this->beUser();
         $user = Sentry::getUser();
         $response = $this->_set200('GET', '/api/v1/users/'.$user->id);
         $data = $this->_getData($response->getContent());
         $this->assertSame($data['email'],$this->userEmail);
    }
    
    // UsersController@edit 
    
    public function testUserEdit404() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set404('PUT', '/api/v1/users/'.$user->id);
    }
    
    public function testUserEdit401() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set401('PUT', '/api/v1/users/'.$user->id);
    }
    
    public function testUserEdit403() 
    {
         $this->beUser();
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set403('PUT', '/api/v1/users/'.$user->id);
    }
    
    public function testUserEdit200() 
    {
         $this->beAdmin();
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set200('PUT', '/api/v1/users/'.$user->id);
    }
    
    // UsersController@account 
    
    public function testUserAccount404() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set404('PUT', '/api/v1/users/'.$user->id.'/account');
    }
    
    public function testUserAccount401() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set401('PUT', '/api/v1/users/'.$user->id.'/account');
    }
    
    public function testUserAccount403() 
    {
         $this->beUser();
         $user = Sentry::findUserByLogin($this->adminEmail);
         $this->_set403('PUT', '/api/v1/users/'.$user->id.'/account');
    }
    
    public function testUserAccount200() 
    {     
         $this->beUser();
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set200('PUT', '/api/v1/users/'.$user->id.'/account');
    }
    
    // UsersController@password 
    
    public function testUserPassword404() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set404('PUT', '/api/v1/users/'.$user->id.'/password');
    }
    
    public function testUserPassword401() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set401('PUT', '/api/v1/users/'.$user->id.'/password');
    }
    
    public function testUserPassword403() 
    {
         $this->beUser();
         $user = Sentry::findUserByLogin($this->adminEmail);
         $this->_set403('PUT', '/api/v1/users/'.$user->id.'/password');
    }
    
    public function testUserPassword200() 
    {     
         $this->beUser();
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set200('PUT', '/api/v1/users/'.$user->id.'/password');
    }
    
    // UsersController@suspend 
    
    public function testUserSuspend404() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set404('PUT', '/api/v1/users/'.$user->id.'/suspend');
    }
    
    public function testUserSuspend401() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set401('PUT', '/api/v1/users/'.$user->id.'/suspend');
    }
    
    public function testUserSuspend403() 
    {
         $this->beUser();
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set403('PUT', '/api/v1/users/'.$user->id.'/suspend');
    }
    
    public function testUserSuspend200() 
    {
         $this->beAdmin();
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set200('PUT', '/api/v1/users/'.$user->id.'/suspend');
    }
    
    // UsersController@unsuspend 
    
    public function testUserUnsuspend404() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set404('PUT', '/api/v1/users/'.$user->id.'/unsuspend');
    }
    
    public function testUserUnsuspend401() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set401('PUT', '/api/v1/users/'.$user->id.'/unsuspend');
    }
    
    public function testUserUnsuspend403() 
    {
         $this->beUser();
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set403('PUT', '/api/v1/users/'.$user->id.'/unsuspend');
    }
    
    public function testUserUnsuspend200() 
    {
         $this->beAdmin();
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set200('PUT', '/api/v1/users/'.$user->id.'/unsuspend');
    }
    
    // UsersController@ban 
    
    public function testUserBan404() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set404('PUT', '/api/v1/users/'.$user->id.'/ban');
    }
    
    public function testUserBan401() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set401('PUT', '/api/v1/users/'.$user->id.'/ban');
    }
    
    public function testUserBan403() 
    {
         $this->beUser();
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set403('PUT', '/api/v1/users/'.$user->id.'/ban');
    }
    
    public function testUserBan200() 
    {
         $this->beAdmin();
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set200('PUT', '/api/v1/users/'.$user->id.'/ban');
    }
    
    // UsersController@destroy 
    
    public function testUserDelete404() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set404('DELETE', '/api/v1/users/'.$user->id);
    }
    
    public function testUserDelete401() 
    {
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set401('DELETE', '/api/v1/users/'.$user->id);
    }
    
    public function testUserDelete403() 
    {
         $this->beUser();
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set403('DELETE', '/api/v1/users/'.$user->id);
    }
    
    public function testUserDelete200() 
    {
         $this->beAdmin();
         $user = Sentry::findUserByLogin($this->userEmail);
         $this->_set200('DELETE', '/api/v1/users/'.$user->id);
    }
    
    // GroupsController@index 
    
    public function testUserGroups404() 
    {
         $this->_set404('GET', '/api/v1/groups');
    }
    
    public function testUserGroups401() 
    {
         $this->_set401('GET', '/api/v1/groups');
    }
    
    public function testUserGroups403() 
    {
         $this->beUser();
         $this->_set403('GET', '/api/v1/groups');
    }
    
    public function testUserGroups200() 
    {
         $this->beAdmin();
         $this->_set200('GET', '/api/v1/groups');
    }
    
    // MenusController@index 
    
    public function testUserMenu404() 
    {
         $this->_set404('GET', '/api/v1/users/menus');
    }
    
    public function testUserMenu404WithoutParameters() 
    {
        $_COOKIE['XSRF-TOKEN'] = $this->cookie;
        $this->client->setServerParameter('HTTP_X-Requested-With', 'XMLHttpRequest');
        $this->client->setServerParameter('HTTP_X-XSRF-TOKEN', $_COOKIE['XSRF-TOKEN']);
        $response = $this->call('GET', '/api/v1/users/menus');
        $this->assertResponseStatus(404);
    }
    
    public function testUserMenu200NoPermission() 
    {
        $query = 'menus[]={"permission":null,"title":"Home","link":"home"}&menus[]={"permission":"users","title":"Users","link":"user_actions.list"}';
        $response = $this->_set200('GET', '/api/v1/users/menus?'.$query);
        $data = $this->_getData($response->getContent());
        $this->assertSame(1, count($data));
    }
    
    public function testUserMenu200WithPermission() 
    {
        $this->beAdmin();
        $query = 'menus[]={"permission":null,"title":"Home","link":"home"}&menus[]={"permission":"users","title":"Users","link":"user_actions.list"}';
        $response = $this->_set200('GET', '/api/v1/users/menus?'.$query);
        $data = $this->_getData($response->getContent());
        $this->assertSame(2, count($data));
    }
   
    // UsersController@activate 
    
    public function testActivate200Success() 
    {
        $response = $this->_set200('POST', '/api/v1/users',array('fullname'=>'user test','username'=>'usertest','email'=>'test@test.com','password'=>'testuser','password_confirmation'=>'testuser'));
        $data = $this->_getData($response->getContent());
        if(!$data['user']['activated']){
            $response = $this->call('GET', '/users/'.$data['user']['id'].'/activate/'.$data['user']['activationCode']);
            $this->assertRedirectedToRoute('home');
        }
        else{
           $response = $this->call('GET', '/users/'.$data['user']['id'].'/activate/fakecode'); 
           $this->assertResponseStatus(404);
        }
    }
    
    // UsersController@reset
    
    public function testResetFails() 
    {
        $response = $this->call('GET', '/users/1/reset/fakecode'); 
        $this->assertResponseStatus(404);
    }
    
    public function testResetSuccess() 
    {
        $response = $this->_set200('POST', '/api/v1/users/forgot',array('email'=>$this->userEmail));
        $user = Sentry::findUserByLogin($this->userEmail);
        $response = $this->call('GET', '/users/'.$user->id.'/reset/'.$user->reset_password_code); 
        $this->assertRedirectedTo('/#!/user/reset-thanks');
    }
    
    // SessionsController@destroy
    
    public function testLogout() 
    {
        $this->beUser();
        $user = Sentry::findUserByLogin($this->userEmail);
        $this->_set200('PUT', '/api/v1/users/'.$user->id.'/account');
        $response = $this->call('GET', '/logout'); 
        $this->_set401('PUT', '/api/v1/users/'.$user->id.'/account');
    }
    
}
