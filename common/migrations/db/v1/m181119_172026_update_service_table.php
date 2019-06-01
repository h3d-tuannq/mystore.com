<?php

use yii\db\Migration;

/**
 * Class m181119_172026_update_service_table
 */
class m181119_172026_update_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('service','discount_money',$this->double());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('service','discount_money');
    }

}
