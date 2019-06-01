<?php

use yii\db\Migration;

/**
 * Class m190115_135551_report_customer_update
 */
class m190115_135551_report_customer_update extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('report_customer', 'count_product_sell', $this->double()->comment('Tổng số lượng bán'));
        $this->addColumn('report_customer', 'count_product_use', $this->double()->comment('Tổng số lượng tiêu hao trong làm dịch vụ'));
        $this->addColumn('report_customer', 'pay', $this->double()->comment('Trả'));
        $this->addColumn('report_customer', 'remain', $this->double()->comment('Nợ lại'));

        $this->addColumn('activity', 'rate_reception', $this->double()->comment('Hoa hồng cho lễ tân'));
        $this->addColumn('activity', 'reception_id', $this->integer()->comment('ID lễ tân'));
        $this->addColumn('activity', 'type', $this->integer()->comment('Kiểu dịch vụ, bảo hành hoặc làm mới'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('report_customer', 'count_product_sell');
        $this->dropColumn('report_customer', 'count_product_use');
        $this->dropColumn('report_customer', 'pay');
        $this->dropColumn('report_customer', 'remain');
        $this->dropColumn('activity', 'rate_reception');
        $this->dropColumn('activity', 'reception_id');
        $this->dropColumn('activity', 'type');
    }


}
