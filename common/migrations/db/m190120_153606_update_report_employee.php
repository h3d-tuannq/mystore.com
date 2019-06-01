<?php

use yii\db\Migration;

/**
 * Class m190120_153606_update_report_employee
 */
class m190120_153606_update_report_employee extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('report_employee','revenue_order',$this->double()->comment('Doanh thu từ hóa đơn'));
        $this->addColumn('report_employee','revenue_order_quantity',$this->integer()->comment('Số lượng hóa đơn'));
        $this->addColumn('report_employee','revenue_activity',$this->double()->comment('Doanh thu Làm dịch vụ'));
        $this->addColumn('report_employee','revenue_activity_quantity',$this->integer()->comment('Số lượng làm dịch vụ'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('report_employee','revenue_order');
        $this->dropColumn('report_employee','revenue_order_quantity');
        $this->dropColumn('report_employee','revenue_activity');
        $this->dropColumn('report_employee','revenue_activity_quantity');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190120_153606_update_report_employee cannot be reverted.\n";

        return false;
    }
    */
}
