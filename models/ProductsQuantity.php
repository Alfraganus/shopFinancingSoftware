<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_quantity".
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $quantity
 * @property int|null $last_changed
 */
class ProductsQuantity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_quantity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'quantity', 'last_changed'], 'integer'],
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
            'quantity' => 'Quantity',
            'last_changed' => 'Last Changed',
        ];
    }

    public function getWeightType()
    {
        return $this->hasOne(AmountTypes::className(), ['id' => 'amount_type']);
    }

    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'product_category_id']);
    }

    public function getProductInfo()
    {
        return $this->hasOne(NewGoods::className(), ['id' => 'product_id']);
    }

}
