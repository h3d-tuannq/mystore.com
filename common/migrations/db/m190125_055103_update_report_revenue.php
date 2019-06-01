<?php

use yii\db\Migration;

/**
 * Class m190125_055103_update_report_revenue
 */
class m190125_055103_update_report_revenue extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('report_revenue','revenue_order',$this->integer()->comment('Số hóa đơn'));
        $this->addColumn('report_revenue','loan',$this->double()->comment('Tổng số nợ'));
        $this->addColumn('report_employee','payment',$this->double()->comment('Khách thanh toán'));
        $this->addColumn('report_employee','loan_day',$this->double()->comment('Nợ trong ngày'));
        $this->addColumn('report_employee','loan',$this->double()->comment('Công nợ'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('report_revenue','revenue_order');
        $this->dropColumn('report_revenue','loan');
        $this->dropColumn('report_employee','payment');
        $this->dropColumn('report_employee','loan_day');
        $this->dropColumn('report_employee','loan');
    }

}
