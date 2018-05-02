<?php

class LoginFormCest
{
    public function _before(\FunctionalTester $I)
    {
        Yii::$app->user->logout();
        $I->amOnRoute('site/login');
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('Login', 'h1');
        $I->cantSee('Send points', 'li');
        $I->cantSee('Personal account', 'li');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByInstance(\FunctionalTester $I)
    {
        $I->amLoggedInAs(\app\models\User::findOrCreateByUsername('admin'));
        $I->amOnPage('/');
        $I->see('Logout (admin)', 'li');
        $I->see('Send points', 'li');
        $I->see('Personal account', 'li');
    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('Username cannot be blank.');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'admin',
        ]);
        $I->see('Logout (admin)');
        $I->dontSeeElement('form#login-form');              
    }
}