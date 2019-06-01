<?php

use yii\db\Migration;

/**
 * Handles the creation of table `customer_history`.
 */
class m181120_234551_create_customer_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('customer_history', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(),
            'object_id' => $this->integer(),
            'object_type' => $this->string()->comment('Sản phẩm, dịch vụ, thẻ nạp'),
            'quantity' => $this->integer()->comment('Số lần sử dụng'),
            'note' => $this->string(1000)->comment('Ghi chú'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // Lịch sử mua thẻ, sử dụng thẻ
        $this->createTable('customer_history_card', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(),
            'card_id' => $this->integer(),
            'amount' => $this->integer()->comment('Số lần sử dụng'),
            'money' => $this->integer()->comment('Số tiền còn lại'),
            'sub_money' => $this->integer()->defaultValue(0)->comment('Số tiền trừ mỗi lần sử dụng'),
            'note' => $this->string(1000)->comment('Ghi chú'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);


        // Lịch sử sử dụng dịch vụ
        $this->createTable('customer_history_service', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(),
            'service_id' => $this->integer(),
            'started_date' => $this->date(),
            'amount' => $this->integer()->comment('Số lần sử dụng của dịch vụ khi mua'),
            'amount_use' => $this->integer()->comment('Số lần đã sử dụng dịch vụ'),
            'amount_remain' => $this->integer()->comment('Số lần còn lại'),
            'note' => $this->string(1000)->comment('Ghi chú'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // Thêm % cho chiết khấu
        $this->addColumn('card','discount_money',$this->double());
        $this->addColumn('product','discount_money',$this->double());

        // Công nợ khách hàng
        $this->addColumn('customer','remain_money',$this->double()->comment('Số tiền còn nợ'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('customer_history');
        $this->dropTable('customer_history_card');
        $this->dropTable('customer_history_service');
        $this->dropColumn('product','discount_money');
        $this->dropColumn('card','discount_money');
    }
}
