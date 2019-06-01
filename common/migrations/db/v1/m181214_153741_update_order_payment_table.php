<?php

use yii\db\Migration;

/**
 * Class m181214_153741_update_order_payment_table
 */
class m181214_153741_update_order_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('order_payment','note','text');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('order_payment','note');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181214_153741_update_order_payment_table cannot be reverted.\n";

        return false;
    }
    */
}
