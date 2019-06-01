<?php

use yii\db\Migration;

/**
 * Handles the creation of table `salary`.
 */
class m181119_105311_create_salary_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('salary', [
            'id' => $this->primaryKey(),
            'year' => $this->integer(),
            'quarter' => $this->integer(),
            'month' => $this->integer(),
            'employee_id' => $this->integer(),
            'total_money' => $this->double()->defaultValue(0),
            'bonus_money' => $this->double()->defaultValue(0)->comment('Chiết khấu'),
            'overtime_money' => $this->double()->defaultValue(0)->comment('Tiền làm thêm'),
            'overtime_time' => $this->integer()->defaultValue(0)->comment('Số phút làm thêm'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('salary');
    }
}
