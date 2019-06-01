<?php

use yii\db\Migration;

/**
 * Class m190129_141527_update_customer_table
 */
class m190129_141527_update_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer','customer_type_id',$this->integer()->comment('Kiểu khách hàng'));
        $this->addColumn('customer','customer_type_code',$this->string()->comment('Mã Kiểu khách hàng'));
        $this->addColumn('customer','notified_at',$this->integer()->comment('Thời điểm nhấc nhở'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('customer','customer_type_code');
        $this->dropColumn('customer','customer_type_id');
        $this->dropColumn('customer','notified_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190129_141527_update_customer_table cannot be reverted.\n";

        return false;
    }
    */
}
