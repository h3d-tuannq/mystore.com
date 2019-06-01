<?php

use yii\db\Migration;

/**
 * Class m181126_095644_update_customer_history_card_table
 */
class m181126_095644_update_customer_history_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer_history_card','service_combo',$this->string(500));
        $this->addColumn('customer_history_card','service_combo_text',$this->string(1000));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('customer_history_card','service_combo');
        $this->dropColumn('customer_history_card','service_combo_text');
    }
}
