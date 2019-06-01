<?php

use yii\db\Migration;

/**
 * Handles the creation of table `service`.
 */
class m181102_123624_create_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_type}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull(),
            'name' => $this->string(512)->notNull(),
            'description' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->insert('service_type', ['slug' => 'ban-le', 'name' => 'Bán lẻ', 'description' => 'Khách mua dịch vụ sử dụng 1 lần', 'created_at' => time(), 'updated_at' => time()]);
        $this->insert('service_type', ['slug' => 'combo', 'name' => 'Combo', 'description' => 'Khách mua combo dịch vụ sử dụng nhiều lần, nhiều dịch vụ', 'created_at' => time(), 'updated_at' => time()]);
        $this->insert('service_type', ['slug' => 'the', 'name' => 'Thẻ', 'description' => 'Khách mua thẻ giá trị', 'created_at' => time(), 'updated_at' => time()]);

        $this->createTable('{{%service}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(1024)->notNull(),
            'name' => $this->string(512)->notNull(),
            'description' => $this->text(),
            'service_type_id' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'thumbnail_base_url' => $this->string(1024),
            'thumbnail_path' => $this->string(1024),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'discount_of_employee' => $this->integer()->comment('Phần trăm chiết khấu của nhân viên'),
            'number_product' => $this->integer(),
            'number_serve' => $this->integer()->comment('Số lần phục vụ của dịch vụ'),
            'number_day' => $this->integer()->comment('Thời hạn của dịch vụ'),
            'on_time' => $this->time()->comment('Thời hạn của dịch vụ'),
            'remain_time' => $this->integer()->comment('Thời gian nhắc lại dịch vụ tính bằng ngày'),
            'warranty' => $this->integer()->comment('Thời gian bảo hành tính bằng giờ'),
            'total_price' => $this->integer()->unsigned()->comment('Giá đầu vào'),
            'retail_price' => $this->integer()->unsigned()->comment('Giá bán ra'),
        ]);

        $this->addForeignKey('fk_service_type_id', '{{%service}}', 'service_type_id', '{{%service_type}}', 'id', 'cascade', 'cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('service');
        $this->dropTable('service_type');
    }
}
