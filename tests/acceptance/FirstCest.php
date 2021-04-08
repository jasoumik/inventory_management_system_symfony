<?php
namespace App\Tests\acceptance;
use App\Tests\_support\AcceptanceTester;
class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginAsExternalUser($I);
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->am('ROLE_USER');
        $I->amOnPage('/');
        $I->see('Welcome');
    }
}
