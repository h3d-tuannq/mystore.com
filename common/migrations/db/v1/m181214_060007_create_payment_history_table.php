<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment_history`.
 * Bảng này sử dụng để lưu lại lịch sử cộng tiền, trừ tiền trong tài khoản của khách hàng
 */
class m181214_060007_create_payment_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('payment_history', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(),
            'before_money' => $this->integer(),
            'change_money' => $this->integer(),
            'current_money' => $this->integer(),
            'reason' => $this->string(),
            'type'=> $this->smallInteger()->notNull()->defaultValue(1)->comment('Kiểu trừ hoặc cộng cho KH, 1 là cộng, 2 trừ'),
            'object_id'=> $this->integer(),
            'object_type' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('payment_history');
    }
}
