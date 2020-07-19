<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales_overall_payment".
 *
 * @property int $id
 * @property int|null $sale_id
 * @property int|null $payment_amount
 * @property int|null $date
 */
class SalesOverallPayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_overall_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_id', 'payment_amount', 'date','cashier'], 'integer'],
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
            'payment_amount' => 'Payment Amount',
            'date' => 'Date',
        ];
    }

    public function getPerson()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'cashier']);
    }
}
