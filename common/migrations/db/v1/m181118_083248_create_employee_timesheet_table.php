<?php

use yii\db\Migration;

/**
 * Handles the creation of table `employee_timesheet`.
 */
class m181118_083248_create_employee_timesheet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('employee_timesheet', [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer(),
            'timesheet_date' => $this->date(),
            'start_time' => $this->dateTime(),
            'end_time' => $this->dateTime(),
            'overtime' => $this->integer()->defaultValue(0)->comment('Số phút làm thêm'),
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
        $this->dropTable('employee_timesheet');
    }
}
