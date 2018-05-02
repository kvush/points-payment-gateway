<?php

namespace app\models;


/**
 * This is the model class for table "transfers".
 *
 * @property int $id
 * @property int $id_from
 * @property int $id_to
 * @property string $amount
 */
class Transfers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transfers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_from', 'id_to', 'amount'], 'required'],
            [['id_from', 'id_to'], 'integer'],
            [['amount'], 'number'],
        ];
    }

    /**
     * Get users who get this payment
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentReceivers()
    {
        return $this->hasOne(User::class, ['id' => 'id_to']);
    }

    /**
     * Get user who make this payment
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentSender()
    {
        return $this->hasOne(User::class, ['id' => 'id_from']);
    }
}
