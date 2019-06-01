<?php

use yii\db\Migration;

/**
 * Class m181123_200118_update_customer_table
 */
class m181123_200118_update_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer','day',$this->smallInteger());
        $this->addColumn('customer','month',$this->smallInteger());
        $this->addColumn('customer','year',$this->smallInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('customer','day');
        $this->dropColumn('customer','month');
        $this->dropColumn('customer','year');
    }
}
