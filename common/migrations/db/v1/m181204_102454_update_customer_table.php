<?php

use yii\db\Migration;

/**
 * Class m181204_102454_update_customer_table
 */
class m181204_102454_update_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer','account_money',$this->integer()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('customer','account_money');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181204_102454_update_customer_table cannot be reverted.\n";

        return false;
    }
    */
}
