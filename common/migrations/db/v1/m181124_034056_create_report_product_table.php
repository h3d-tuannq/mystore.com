<?php

use yii\db\Migration;

/**
 * Handles the creation of table `report_product`.
 */
class m181124_034056_create_report_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('report_product', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'product_name' => $this->string(),
            'product_code' => $this->string(),
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
        $this->dropTable('report_product');
    }
}
