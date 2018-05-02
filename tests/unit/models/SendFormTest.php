<?php

namespace tests\models;

use app\models\Transfers;
use app\models\User;
use PHPUnit\Framework\Exception;


class SendFormTest extends \Codeception\Test\Unit
{
    /** @var \app\models\SendForm $model */
    private $model;
    /** @var  int */
    private $sender_id;
    /**@var \UnitTester */
    protected $tester;

    protected function _before()
    {
        User::deleteAll();
        Transfers::deleteAll();
        $this->initDemoUsers();
    }

    protected function _after()
    {
    }

    /**
     * Test that send action available only for an authorized user
     */
    public function testPointsCanSendByOnlyAuthorizedUsers()
    {
        $this->model = new \app\models\SendForm([
            'receiverName' => 'demo',
            'amount' => 100
        ]);

        \Yii::$app->user->identity = null;
        expect_not($this->model->validate());
        expect($this->model->errors)->hasKey('receiverName');
    }

    /**
     * Test that we can send point for not existing user, this way user must be created and balance have to be updated
     */
    public function testSendPointsToNotExistingUser()
    {
        $this->model = new \app\models\SendForm([
            'receiverName' => 'not_exist',
            'amount' => 777
        ]);

        $this->loginSender();
        expect_that($this->model->makeTransfer());
        expect("that new user have been created", User::findOne(['name' => 'not_exist']))->notNull();
        expect("that not_exist user has new balance now, equals to", User::findOne(['name' => 'not_exist'])->balance)->equals(777);
        expect("that sender has balance now, equals to", User::findOne(['name' => 'sender'])->balance)->equals(5000-777);
    }

    /**
     * Test that user can't send more then he has plus 1000 points (minimum balance -1000)
     */
    public function testCantSendFromLowBalance()
    {
        $this->model = new \app\models\SendForm([
            'receiverName' => 'demo',
            'amount' => 0.02
        ]);
        $this->loginSender('no-money');
        expect_not($this->model->makeTransfer());
        expect($this->model->errors)->hasKey('amount');
    }

    /**
     * Test that user can't send negative amount
     */
    public function testCantSendNegativeAmount()
    {
        $this->model = new \app\models\SendForm([
            'receiverName' => 'demo',
            'amount' => -100
        ]);
        $this->loginSender();
        expect_not($this->model->makeTransfer());
        expect($this->model->errors)->hasKey('amount');
    }

    /**
     * Test that user can't send points to his self
     */
    public function testCantSendToSelfBalance()
    {
        $this->model = new \app\models\SendForm([
            'receiverName' => 'sender',
            'amount' => 100
        ]);
        $this->loginSender();
        expect_not($this->model->makeTransfer());
        expect($this->model->errors)->hasKey('receiverName');
    }

    /**
     * Init test data
     */
    private function initDemoUsers() {
        $user = new User();
        $user->name = "sender";
        $user->balance = 5000;
        if ($user->save()) {
            $this->sender_id = $user->id;
        } else {
            throw new Exception("Can't create sender user.");
        }

        $user = new User();
        $user->name = "no-money";
        $user->balance = -999.99;
        if (!$user->save()) {
            throw new Exception("Can't create sender user");
        }

        $user = new User();
        $user->name = "demo";
        $user->balance = 0;
        if (!$user->save()) {
            throw new Exception("Can't create sender user");
        }
    }

    /**
     * Login sender user
     */
    private function loginSender($name = null)
    {
        if (is_null($name)) {
            $user = User::findOne($this->sender_id);
        }
        else {
            $user = User::findOne(['name' => $name]);
            if (is_null($user)) {
                $user = User::findOne(['name' => 'sender']);
            }
        }
        \Yii::$app->user->login($user);
    }
}