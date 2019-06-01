<?php

use yii\db\Migration;

/**
 * Handles the creation of table `report_revenue`.
 */
class m181119_103321_create_report_revenue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('report_revenue', [
            'id' => $this->primaryKey(),
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
        $this->dropTable('report_revenue');
    }
}
