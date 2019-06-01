<?php

use yii\db\Migration;

/**
 * Handles the creation of table `activity`.
 */
class m181204_020550_create_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('activity', [
            'id' => $this->primaryKey(),
            'service_id' => $this->integer(),
            'service_name' => $this->string(),
            'customer_id' => $this->integer(),
            'customer_name' => $this->string(),
            'employee_id' => $this->integer()->comment('Nhân viên yêu cầu'),
            'start_time' => $this->integer(),
            'end_time' => $this->integer(),
            'bed' => $this->string()->comment('Số giường'),
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
        $this->dropTable('activity');
    }
}
