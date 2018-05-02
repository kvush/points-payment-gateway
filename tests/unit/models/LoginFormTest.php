<?php

namespace tests\models;

use app\models\LoginForm;

class LoginFormTest extends \Codeception\Test\Unit
{
    private $model;

    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    /**
     * Test creating user, in case if we login under not existing name
     */
    public function testLoginNoUser()
    {
        $this->model = new LoginForm([
            'username' => 'not_existing_username',
        ]);

        expect_that($this->model->login());
        expect_not(\Yii::$app->user->isGuest);
        expect(\Yii::$app->user->getIdentity()->name)->equals('not_existing_username');
        expect("balance for new user", \Yii::$app->user->getIdentity()->balance)->equals(0);
    }

    /**
     * Test form validation
     */
    public function testNoLoginWithNoUserName()
    {
        $this->model = new LoginForm([
            'username' => '',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasKey('username');
    }

}
