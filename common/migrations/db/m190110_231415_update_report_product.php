<?php

use yii\db\Migration;

/**
 * Class m190110_231415_update_report_product
 */
class m190110_231415_update_report_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('report_product','quantity',$this->double()->comment('Tổng số lượng tiêu hao'));
        $this->addColumn('report_product','quantity_sell',$this->double()->comment('Tổng số lượng bán trong hóa đơn'));
        $this->addColumn('report_product','quantity_use',$this->double()->comment('Tổng số lượng tiêu hao trong làm dịch vụ'));
        $this->addColumn('report_product','quantity_remain',$this->double()->comment('Tổng số lượng tồn kho'));
        $this->addColumn('report_product','unit',$this->string()->comment('Đơn vị'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('report_product','quantity');
        $this->dropColumn('report_product','quantity_sell');
        $this->dropColumn('report_product','quantity_use');
        $this->dropColumn('report_product','quantity_remain');
        $this->dropColumn('report_product','unit');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190110_231415_update_report_product cannot be reverted.\n";

        return false;
    }
    */
}
