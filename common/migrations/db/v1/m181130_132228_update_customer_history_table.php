<?php

use yii\db\Migration;

/**
 * Class m181130_132228_update_customer_history_table
 */
class m181130_132228_update_customer_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer_history','started_date',$this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('customer_history','started_date');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181130_132228_update_customer_history_table cannot be reverted.\n";

        return false;
    }
    */
}
