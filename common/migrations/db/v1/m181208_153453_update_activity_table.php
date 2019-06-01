<?php

use yii\db\Migration;

/**
 * Class m181208_153453_update_activity_table
 */
class m181208_153453_update_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('activity','object_id',$this->integer());
        $this->addColumn('activity','object_type',$this->string());
        $this->addColumn('activity','detail',$this->text()->comment('Lưu dịch vụ'));
        $this->addColumn('activity','detail_products',$this->text()->comment('Tiêu hao sản phẩm'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('activity','object_type');
        $this->dropColumn('activity','object_id');
        $this->dropColumn('activity','detail');
        $this->dropColumn('activity','detail_products');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181208_153453_update_activity_table cannot be reverted.\n";

        return false;
    }
    */
}
