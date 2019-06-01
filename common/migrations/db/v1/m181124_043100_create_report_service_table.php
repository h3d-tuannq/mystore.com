<?php

use yii\db\Migration;

/**
 * Handles the creation of table `report_service`.
 */
class m181124_043100_create_report_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('report_service', [
            'id' => $this->primaryKey(),
            'service_id' => $this->integer(),
            'service_name' => $this->string(),
            'service_code' => $this->string(),
            'year' => $this->integer(),
            'quarter' => $this->integer(),
            'month' => $this->integer(),
            'week' => $this->integer(),
            'report_date' => $this->date()->notNull(),
            'revenue' => $this->double()->defaultValue(0),
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
        $this->dropTable('report_service');
    }
}
