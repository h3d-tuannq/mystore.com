<?php

use yii\db\Migration;

/**
 * Handles the creation of table `appointment`.
 */
class m181104_105553_create_appointment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('appointment', [
            'id' => $this->primaryKey(),
            'service_id' => $this->integer(),
            'service_name' => $this->string(),
            'customer_id' => $this->integer(),
            'customer_name' => $this->string(),
            'appointment_time' => $this->integer(),
            'number_customer' => $this->integer()->defaultValue(1),
            'employee_id' => $this->integer()->comment('Nhân viên yêu cầu'),
            'phone' => $this->string()->comment('Số điện thoại đặt hẹn'),
            'note' => $this->string(500)->comment('Ghi chú'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('appointment');
    }
}
