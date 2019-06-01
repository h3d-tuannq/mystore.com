<?php

use yii\db\Migration;

/**
 * Class m190128_115342_update_report_service
 */
class m190128_115342_update_report_service extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('report_service','employee',$this->text()->comment('Nhân viên'));
        $this->addColumn('report_service','employee_service',$this->text()->comment('Nhân viên'));
        $this->addColumn('report_service','quantity',$this->integer()->comment('Số lượng làm dịch vụ'));
        $this->addColumn('report_service','sell',$this->integer()->comment('Bán'));
        $this->addColumn('report_service','use',$this->integer()->comment('Sử dụng'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('report_service','employee');
        $this->dropColumn('report_service','employee_service');
        $this->dropColumn('report_service','quantity');
        $this->dropColumn('report_service','sell');
        $this->dropColumn('report_service','use');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190128_115342_update_report_service cannot be reverted.\n";

        return false;
    }
    */
}
