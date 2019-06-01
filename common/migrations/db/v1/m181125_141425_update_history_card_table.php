<?php

use yii\db\Migration;

/**
 * Class m181125_141425_update_history_card_table
 */
class m181125_141425_update_history_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer_history_card','started_date',$this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('customer_history_card','started_date');
    }
}
