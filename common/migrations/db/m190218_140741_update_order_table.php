<?php

use yii\db\Migration;

/**
 * Class m190218_140741_update_order_table
 */
class m190218_140741_update_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('order','order_id',$this->integer()->comment('Hóa đơn sẽ trả nợ'));
        $this->addColumn('order','type',$this->integer()->defaultValue(1)->comment('1 hóa đơn mua hàng, 2 hóa đơn trả nợ'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('order','type');
        $this->dropColumn('order','order_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190218_140741_update_order_table cannot be reverted.\n";

        return false;
    }
    */
}
