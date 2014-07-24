<?php
use \AcceptanceTester;

class SessionControllerCest
{
    
    public function _before(\AcceptanceTester $I)
    {
        $I->wantTo('Grab the XSRF-TOKEN cookie value');
        $I->amOnPage('/');
        $text = $I->grabTextFrom('body > div > script');
        $chunks1 = explode("\n", trim($text));
        $chunks2 = explode("=", trim($chunks1[1]));
        $cookieValue = rtrim($chunks2[2], ';"');
        $I->setCookie('XSRF-TOKEN',$cookieValue);
        $I->setHeader('X-XSRF-TOKEN',$cookieValue);
    }

    public function _after()
    {
    }

    // tests
    public function invalidUserShouldBe200AndJsonTest(AcceptanceTester $I)
    {
        $I->wantTo('To see a 200 status code and a json response');
        $I->sendAjaxPostRequest('/api/v1/signin',array('email'=>'user@user.com','password'=>'sentryuser'));
        $I->seeCookie('XSRF-TOKEN');
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();// until here green bar
       // dd($I->grabResponse()); // empty string
        //$I->seeResponseContainsJson(array('success' => 0,'errors' => array('error' => array('Invalid username or password.'))));
        
        $I->seeResponseContains(""); // red bar 
    }
}