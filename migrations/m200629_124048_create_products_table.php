<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m200629_124048_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('new_goods', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'amount_type' => $this->integer(11)->null(),
            'initial_price'=> $this->float(),
            'product_category'=>$this->integer()->null(),
            'created_at'=>$this->integer()->null(),
            'created_by'=>$this->integer()->null(),
            'updated_at'=>$this->integer()->null(),
            'updated_by'=>$this->integer()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('new_goods');
    }
}
