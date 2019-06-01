<?php

use yii\db\Migration;

/**
 * Class m181119_061525_update_product_table
 */
class m181119_061525_update_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product','quantity','integer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn('product','quantity');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181119_061525_update_product_table cannot be reverted.\n";

        return false;
    }
    */
}
