<?php

use yii\db\Migration;

/**
 * Handles the creation of table `report_payment`.
 */
class m190131_135623_create_report_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('report_payment', [
            'id' => $this->primaryKey(),
            'payment_id' => $this->integer(),
            'payment_name' => $this->string(),
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
        $this->dropTable('report_payment');
    }
}
