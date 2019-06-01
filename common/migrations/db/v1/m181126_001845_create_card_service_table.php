<?php

use yii\db\Migration;

/**
 * Handles the creation of table `card_service`.
 */
class m181126_001845_create_card_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('card_service', [
            'id' => $this->primaryKey(),
            'card_id' => $this->integer(),
            'service_id' => $this->integer(),
            'amount' => $this->integer()->unsigned()->defaultValue(0)->comment('Số lượng'),
            'money' => $this->integer()->unsigned()->defaultValue(0)->comment('Tiền theo số lượng'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('fk_card', '{{%card_service}}', 'card_id', '{{%card}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_service', '{{%card_service}}', 'service_id', '{{%service}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_card_service_author', '{{%card_service}}', 'created_by', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_card_service_updater', '{{%card_service}}', 'updated_by', '{{%user}}', 'id', 'set null', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_card_service_updater', '{{%card_service}}');
        $this->dropForeignKey('fk_card_service_author', '{{%card_service}}');
        $this->dropForeignKey('fk_service', '{{%card_service}}');
        $this->dropForeignKey('fk_card', '{{%card_service}}');

        $this->dropTable('card_service');
    }
}
