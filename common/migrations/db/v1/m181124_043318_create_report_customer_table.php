<?php

use yii\db\Migration;

/**
 * Handles the creation of table `report_customer`.
 */
class m181124_043318_create_report_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('report_customer', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(),
            'customer_name' => $this->string(),
            'customer_code' => $this->string(),
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
        $this->dropTable('report_customer');
    }
}
