<?php

use yii\db\Migration;

/**
 * Handles the creation of table `customer`.
 */
class m181103_151248_create_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_type}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->insert('customer_type', ['slug' => 'khach-dich-vu', 'name' => 'Khách dịch vụ', 'description' => 'Khách dịch vụ', 'created_at' => time(), 'updated_at' => time()]);
        $this->insert('customer_type', ['slug' => 'khach-le', 'name' => 'Khách lẻ', 'description' => 'Khách lẻ', 'created_at' => time(), 'updated_at' => time()]);
        $this->insert('customer_type', ['slug' => 'khach-vip', 'name' => 'Khách VIP', 'description' => 'Khách VIP', 'created_at' => time(), 'updated_at' => time()]);
        $this->insert('customer_type', ['slug' => 'khach-cho-tu-van', 'name' => 'Khách chờ tư vấn', 'description' => 'Khách chưa chốt sử dụng dịch vụ cần tư vấn thêm', 'created_at' => time(), 'updated_at' => time()]);
        $this->insert('customer_type', ['slug' => 'khach-san-tmdt', 'name' => 'Khách các sàn TMĐT', 'description' => 'Khách trên các sàn TMĐT khác', 'created_at' => time(), 'updated_at' => time()]);
        $this->insert('customer_type', ['slug' => 'khach-tri-lieu', 'name' => 'Khách trị liệu', 'description' => 'Khách trị liệu', 'created_at' => time(), 'updated_at' => time()]);
        $this->insert('customer_type', ['slug' => 'khach-mua-san-pham', 'name' => 'Khách mua sản phẩm', 'description' => 'Khách mua sản phẩm', 'created_at' => time(), 'updated_at' => time()]);
        $this->insert('customer_type', ['slug' => 'khach-tiem-nang', 'name' => 'Khách tiềm năng', 'description' => 'Phân loại khách tiềm năng', 'created_at' => time(), 'updated_at' => time()]);

        $this->createTable('{{%customer}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull(),
            'name' => $this->string(512)->notNull()->comment('Tên khách hàng'),
            'birth_of_date' => $this->integer(),
            'phone' => $this->string(),
            'identify' => $this->string(),
            'address' => $this->string(512),
            'email' => $this->string(),
            'source' => $this->integer()->comment('Nguồn khách'),
            'gender' => $this->smallInteger()->defaultValue(2)->comment('Giới tính, 1 là nam, 2 là nữ'),
            'group' => $this->string()->comment('Nhóm khách'),
            'is_notification_birthday' => $this->integer()->comment('Bật tắt thống báo ngày sinh'),
            'is_notification_service' => $this->integer()->comment('Bật tắt thống báo ngày sinh'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'thumbnail_base_url' => $this->string(1024),
            'thumbnail_path' => $this->string(1024),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->createTable('{{%customer_service}}', [
            'id' => $this->primaryKey(),
            'service_id' => $this->integer(),
            'customer_id' => $this->integer(),
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
        $this->dropTable('customer_service');
        $this->dropTable('customer');
        $this->dropTable('customer_type');
    }
}
