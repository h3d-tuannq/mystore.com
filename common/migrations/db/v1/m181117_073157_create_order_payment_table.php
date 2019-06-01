<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_payment`.
 */
class m181117_073157_create_order_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%payment}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('order_payment', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'payment_id' => $this->integer()->defaultValue(1)->comment('Hình thức thanh toán'),
            'total_money' => $this->integer()->unsigned()->defaultValue(0)->comment('Số tiền'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('fk_order_payment_order', '{{%order_payment}}', 'order_id', '{{%order}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_order_payment_payment', '{{%order_payment}}', 'payment_id', '{{%payment}}', 'id', 'cascade', 'cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order_payment');
        $this->dropTable('payment');
    }
}
