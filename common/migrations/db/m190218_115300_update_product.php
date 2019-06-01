<?php

use yii\db\Migration;

/**
 * Class m190218_115300_update_product
 */
class m190218_115300_update_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product','limit_quantity',$this->integer()->defaultValue(10)->comment('Số lượng còn tối thiểu sẽ có thông báo'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('product','limit_quantity');
    }

}
