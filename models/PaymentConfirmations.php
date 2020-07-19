<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_confirmations".
 *
 * @property int $id
 * @property int|null $sale_id
 * @property int|null $payment_type
 * @property int|null $payment_amount
 * @property int|null $time
 */
class PaymentConfirmations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_confirmations';
    }
    public $payment_amount_post;
    public $paymentData;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_id', 'payment_type', 'payment_amount', 'time','payment_amount_post','paymentData'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sale_id' => 'Sale ID',
            'payment_type' => 'Payment Type',
            'payment_amount' => 'Payment Amount',
            'time' => 'Time',
        ];
    }

    public function getSalesman()
    {
        return $this->hasOne(sales::className(), ['sale_id' => 'sale_id']);
    }

}
