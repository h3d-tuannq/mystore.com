<?php

use yii\db\Migration;

/**
 * Class m181126_062644_update_customer_history_service_table
 */
class m181126_062644_update_customer_history_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer_history_service','service_combo',$this->string(500));
        $this->addColumn('customer_history_service','service_combo_text',$this->string(1000));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('customer_history_service','service_combo');
        $this->dropColumn('customer_history_service','service_combo_text');
    }
}
