<?php

use yii\db\Migration;

/**
 * Class m181123_060118_update_customer_table
 */
class m181123_060118_update_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('customer','birth_of_date',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
