<?php

use yii\db\Migration;

/**
 * Class m200629_123157_create_categoryProducts
 */
class m200629_123157_create_categoryProducts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_category', [
            'id' => $this->primaryKey(),
            'name' => $this->string(180)->notNull(),
            'status' => $this->integer(5),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200629_123157_create_categoryProducts cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200629_123157_create_categoryProducts cannot be reverted.\n";

        return false;
    }
    */
}
