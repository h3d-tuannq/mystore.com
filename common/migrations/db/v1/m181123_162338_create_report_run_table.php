<?php

use yii\db\Migration;

/**
 * Handles the creation of table `report_run`.
 */
class m181123_162338_create_report_run_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('report_run', [
            'id' => $this->primaryKey(),
            'run_date' => $this->date(),
            'run_day' => $this->tinyInteger(),
            'run_month' => $this->tinyInteger(),
            'run_year' => $this->smallInteger(),
            'birthday' => $this->tinyInteger(),
            'revenue' => $this->tinyInteger(),
            'discount' => $this->tinyInteger()->comment('Chiết khấu'),
            'salary' => $this->tinyInteger()->comment('Lương'),
            'remain' => $this->tinyInteger()->comment('Công nợ'),
            'overtime' => $this->tinyInteger()->comment('thời gian làm ngoài giờ'),
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
        $this->dropTable('report_run');
    }
}
