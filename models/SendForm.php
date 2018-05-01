<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SendForm extends Model
{
    /** @var  string */
    public $receiverName;

    /** @var  string */
    public $amount;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['receiverName', 'amount'], 'required'],
            [['receiverName'], 'string', 'max' => 100],
            [['amount'], 'number', 'min' => 0.01],
            ['receiverName', 'checkReceiverName'],
            ['amount', 'checkAvailableBalance']
        ];
    }

    /**
     * Check that user do not send points to his self
     *
     * @param $attribute
     * @param $params
     */
    public function checkReceiverName($attribute, $params)
    {
        if (Yii::$app->user->isGuest) {
            $this->addError($attribute, 'You must be authorized first');
        }
        if (strcasecmp(Yii::$app->user->identity->name, $this->$attribute) == 0) {
            $this->addError($attribute, 'You can\'t send money to your self');
        }
    }

    /**
     * Check current users balance before send points.
     *
     * @param $attribute
     * @param $params
     */
    public function checkAvailableBalance($attribute, $params)
    {
        if (Yii::$app->user->isGuest) {
            $this->addError($attribute, 'You must be authorized first');
        }
        $balance = (int)User::findOrCreateByUsername(Yii::$app->user->identity->name)->balance;
        if (($balance - (int)$this->$attribute) <= -1000) {
            $available = $balance + 1000;
            $this->addError($attribute, "Your balance to low, maximum you can send is: $available point");
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    function makeTransfer()
    {
        if ($this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $transfer = new Transfers();
                $transfer->id_from = Yii::$app->user->id;
                $transfer->id_to = User::findOrCreateByUsername($this->receiverName)->id;
                $transfer->amount = $this->amount;
                $transfer->save();

                $user = User::findOne($transfer->id_from);
                $user->balance = 0.00 + $user->balance - $transfer->amount;
                $user->save();

                $user = User::findOne($transfer->id_to);
                $user->balance = 0.00 + $user->balance + $transfer->amount;
                $user->save();

                $transaction->commit();
                return true;
            }
            catch (\Exception $e) {
                $transaction->rollBack();
                return false;
            }
            catch (\Throwable $e) {
                $transaction->rollBack();
                return false;
            }
        }
        return false;
    }
}
