<?php

use yii\db\Migration;

/**
 * Handles the creation of table `card`.
 */
class m181104_101427_create_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%card_type}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->insert('card_type', ['slug' => 'the-tien', 'name' => 'Thẻ Tiền', 'description' => 'Thẻ Tiền', 'created_at' => time(), 'updated_at' => time()]);
        $this->insert('card_type', ['slug' => 'the-dich-vu', 'name' => 'Thẻ Dịch Vụ', 'description' => 'Thẻ Tiền', 'created_at' => time(), 'updated_at' => time()]);

        $this->createTable('card', [
            'id' => $this->primaryKey(),
            'card_type' => $this->integer()->comment('Kiểu thẻ'),
            'name' => $this->string(512)->comment('Tên thẻ'),
            'slug' => $this->string(512)->notNull(),
            'amount' => $this->integer()->unsigned()->comment('Mệnh giá thẻ'),
            'rate_employee' => $this->decimal()->comment('Phần trăm Chiết khấu cho nhân viên'),
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
        $this->dropTable('card');
        $this->dropTable('card_type');
    }
}
