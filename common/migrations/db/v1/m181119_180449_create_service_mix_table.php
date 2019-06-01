<?php

use yii\db\Migration;

/**
 * Handles the creation of table `service_mix`.
 */
class m181119_180449_create_service_mix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('service_mix', [
            'id' => $this->primaryKey(),
            'service_mix_id' => $this->integer(),
            'service_id' => $this->integer(),
            'amount' => $this->integer()->unsigned()->defaultValue(0)->comment('Số lượng'),
            'money' => $this->integer()->unsigned()->defaultValue(0)->comment('Tiền theo số lượng'),
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
        $this->dropTable('service_mix');
    }
}
