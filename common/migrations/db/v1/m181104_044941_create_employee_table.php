<?php

use yii\db\Migration;

/**
 * Handles the creation of table `employee`.
 */
class m181104_044941_create_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employee_type}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->insert('employee_type', ['slug' => 'tho-chinh', 'name' => 'Thợ chính', 'description' => 'Thợ chính', 'created_at' => time(), 'updated_at' => time()]);
        $this->insert('employee_type', ['slug' => 'tho-phu', 'name' => 'Thợ phụ', 'description' => 'Thợ phụ', 'created_at' => time(), 'updated_at' => time()]);
        $this->insert('employee_type', ['slug' => 'stylist', 'name' => 'stylist', 'description' => 'Stylist', 'created_at' => time(), 'updated_at' => time()]);

        $this->createTable('{{%employee}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull(),
            'name' => $this->string(512)->notNull()->comment('Tên nhân viên'),
            'birth_of_date' => $this->integer(),
            'phone' => $this->string(),
            'identify' => $this->string(),
            'email' => $this->string(),
            'gender' => $this->smallInteger()->defaultValue(2)->comment('Giới tính, 1 là nam, 2 là nữ'),
            'salary' => $this->integer()->comment('Lương cơ bản'),
            'rate_revenue' => $this->decimal()->comment('Phần trăm chiết khấu doanh thu'),
            'rate_overtime' => $this->decimal()->comment('Phần trăm chiết khấu ngoài giờ'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'thumbnail_base_url' => $this->string(1024),
            'thumbnail_path' => $this->string(1024),
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
        $this->dropTable('employee');
        $this->dropTable('employee_type');
    }
}
