<?php

use yii\db\Migration;

/**
 * Class m190215_115342_update_report_service
 */
class m190215_115342_update_report_service extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('report_service','spend',$this->double()->defaultValue(0)->comment('Chi'));
        $this->addColumn('report_service','proceed',$this->double()->defaultValue(0)->comment('Thu'));
        $this->addColumn('report_service','interest',$this->double()->defaultValue(0)->comment('Lãi'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('report_service','spend');
        $this->dropColumn('report_service','proceed');
        $this->dropColumn('report_service','interest');
    }

}
