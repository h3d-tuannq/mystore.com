<?php

use yii\db\Migration;

/**
 * Class m181218_141336_update_appoinment_table
 */
class m181218_141336_update_appoinment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('appointment','end_time',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('appointment','end_time');
    }
}
