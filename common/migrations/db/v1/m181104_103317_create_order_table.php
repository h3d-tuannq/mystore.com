<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m181104_103317_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->comment('Mã Hóa đơn'),
            'customer_id' => $this->integer(),
            'discount' => $this->decimal()->comment('Chiết khấu cho khách hàng'),
            'rate_receptionist' => $this->decimal()->defaultValue(0)->comment('Phần trăm hoa hồng cho lễ tân'),
            'rate_receptionist_id' => $this->decimal()->defaultValue(0)->comment('ID của nhân viên lễ tân'),
            'rate_employee' => $this->decimal()->defaultValue(0)->comment('Phần trăm hoa hồng của nhân viên'),
            'rate_employee_id' => $this->integer()->comment('ID của nhân viên'),
            'raw_money' => $this->integer()->unsigned()->defaultValue(0)->comment('Số tiền trước khi giảm giá'),
            'total_money' => $this->integer()->unsigned()->defaultValue(0),
            'real_money' => $this->integer()->unsigned()->defaultValue(0)->comment('Số tiền nhập kho'),
            'payment_type' => $this->smallInteger()->defaultValue(1)->comment('Hình thức thanh toán'),
            'voucher_code' => $this->string()->comment('Mã voucher'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->createTable('order_detail', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'object_id' => $this->integer(),
            'object_type' => $this->string(),
            'quantity' => $this->integer()->defaultValue(1),
            'unit_money' => $this->integer()->unsigned()->defaultValue(0),
            'total_money' => $this->integer()->unsigned()->defaultValue(0),
            'employee_id' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        $this->addForeignKey('fk_order_detail_order', '{{%order_detail}}', 'order_id', '{{%order}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order');
        $this->dropTable('order_detail');
    }
}
