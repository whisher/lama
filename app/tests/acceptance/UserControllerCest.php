<?php
use \AcceptanceTester;

class UserControllerCest
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

    
    public function userShouldBe401Test(AcceptanceTester $I)
    {
        $I->wantTo('To see a 401 status code');
        $I->sendAjaxRequest('GET', '/api/v1/user');
        $I->seeResponseCodeIs('401');
    }
}