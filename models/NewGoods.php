<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "new_goods".
 *
 * @property int $id
 * @property string $name
 * @property int $amount_type
 * @property float $amount
 * @property int|null $prices_id
 * @property int $initial_price
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class NewGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'new_goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount_type', 'amount', 'initial_price'], 'required'],
            [['amount_type','product_category', 'initial_price', 'product_category','created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['is_confirmed'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Maxsulot nomi',
            'amount_type' => 'Miqdor o\'lchovi',
            'amount' => 'Miqdori',
            'prices_id' => 'Prices ID',
            'initial_price' => 'Olib kelingan narxi',
            'created_at' => 'Tizimga kiritilgan sana',
            'created_by' => 'Tizimga kiritgan foydalanuvchi:',
            'updated_at' => 'Taxrirlangan sana',
            'updated_by' => 'Taxrirlagan foydalanuvchi',
            'product_category'=>'Maxsulot nomi',
            'is_transfered'=>'Topshirildi'
        ];
    }



    public function getWeightType()
    {
        return $this->hasOne(AmountTypes::className(), ['id' => 'amount_type']);
    }

    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'product_category']);
    }

    public function getCreatedPerson()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }


}
