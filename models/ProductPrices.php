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
            [['product_id', 'price'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'price' => 'Price',
        ];
    }
}
