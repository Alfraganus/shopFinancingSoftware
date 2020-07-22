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
            'sale_id' => 'Xarid ID',
            'payment_type' => 'Tolov turi',
            'payment_amount' => 'Summa',
            'time' => 'Vaqt',
        ];
    }

    public function ExportData($start,$end)
    {
        if(!empty($start) && !empty($end))
        {
            $query =  PaymentConfirmations::find()->where(['between','time',$start,$end]);
        } else {
            $query =  PaymentConfirmations::find();
        }
        $file = \Yii::createObject([
            'class' => 'codemix\excelexport\ExcelFile',
            'sheets' => [
                'Users' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => $query,
                    'attributes' => [
                        'sale_id',
                        'payment_type',
                        'payment_amount',
                    ],
                ]
            ]
        ]);
        return $file->send('savdo_tolov_turlari.xlsx');
    }


    public function getSalesman()
    {
        return $this->hasOne(sales::className(), ['sale_id' => 'sale_id']);
    }

}
