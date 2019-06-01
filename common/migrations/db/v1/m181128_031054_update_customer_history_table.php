<?php

use yii\db\Migration;

/**
 * Class m181128_031054_update_customer_history_table
 */
class m181128_031054_update_customer_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('customer_history','data',$this->text());
        $this->addColumn('customer_history','amount',$this->integer()->unsigned());
        $this->addColumn('customer_history','sub',$this->integer()->unsigned());
        $this->addColumn('customer_history','remain',$this->integer()->unsigned());
        $this->addColumn('customer_history','order_id',$this->integer());


        // Lịch sử từng lần sử dụng
        $this->createTable('customer_history_detail', [
            'id' => $this->primaryKey(),
            'history_id' => $this->integer(),
            'customer_id' => $this->integer(),
            'object_id' => $this->integer(),
            'object_type' => $this->integer(),
            'used_at' => $this->integer()->comment('Ngày sử dụng'),
            'amount' => $this->integer()->comment('Số lượng'),
            'price' => $this->integer()->unsigned()->comment('Giá'),
            'total_price' => $this->integer()->unsigned()->comment('Giá'),
            'type' => $this->string(100)->comment('Kiểu dùng'),
            'note' => $this->string(1000)->comment('Ghi chú'),
            'data' => $this->string(1000)->comment('Lưu json cần thiết'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('fk_customer_history_detail_history', '{{%customer_history_detail}}', 'history_id',
            '{{%customer_history}}', 'id', 'set null', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('customer_history','data');
        $this->dropColumn('customer_history','amount');
        $this->dropColumn('customer_history','sub');
        $this->dropColumn('customer_history','remain');
        $this->dropColumn('customer_history','order_id');

        $this->dropIndex('fk_customer_history_detail_history','customer_history_detail');

        $this->dropTable('customer_history_detail');
    }

}
