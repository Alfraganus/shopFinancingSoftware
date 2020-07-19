<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_prices".
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $price
 */
class ProductPrices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_prices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id','product_id', 'price','price_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'price' => 'Price',
        ];
    }





}
