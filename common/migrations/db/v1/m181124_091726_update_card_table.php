<?php

use yii\db\Migration;

/**
 * Class m181124_091726_update_card_table
 */
class m181124_091726_update_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Có 1: giá trị thẻ của khách 2: giá trị tặng dv cho khách
        // 3: giá gốc ( cộng dồn 2 cái trên lại)
        // 4: giá trị khách phải thanh toán( giá bán lẻ)
        $this->addColumn('card','bonus_price','integer');
        $this->addColumn('card','raw_price','integer'); // Amount + bonus
        $this->addColumn('card','retail_price','integer'); // Giá bán lẻ
        $this->addColumn('card','description',$this->string(1000)); // Mô tả
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('card','retail_price');
        $this->dropColumn('card','raw_price');
        $this->dropColumn('card','bonus_price');
    }
}
