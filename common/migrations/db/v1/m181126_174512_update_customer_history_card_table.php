<?php

use yii\db\Migration;

/**
 * Class m181126_174512_update_customer_history_card_table
 */
class m181126_174512_update_customer_history_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer_history_card','card_product',$this->string(500));
        $this->addColumn('customer_history_card','card_product_text',$this->string(1000));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('customer_history_card','card_product');
        $this->dropColumn('customer_history_card','card_product_text');
    }
}
