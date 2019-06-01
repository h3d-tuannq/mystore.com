<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product`.
 */
class m181103_084515_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_type}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull(),
            'name' => $this->string(512)->notNull(),
            'group' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('{{%product_unit}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull(),
            'name' => $this->string(512)->notNull(),
            'description' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);


        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(512)->notNull(),
            'name' => $this->string(512)->notNull(),
            'description' => $this->text(),
            'product_type_id' => $this->integer(),
            'product_type' => $this->string(),
            'product_unit_id' => $this->integer(),
            'product_unit' => $this->string(),
            'specification' => $this->string()->comment('Quy cách'),
            'made_in' => $this->string()->comment('Xuất xứ'),
            'input_price' => $this->integer()->unsigned()->comment('Giá đầu vào'),
            'retail_price' => $this->integer()->unsigned()->comment('Giá bán ra'),
            'rate_employee' => $this->decimal()->comment('Phần trăm chiết khấu của nhân viên'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'thumbnail_base_url' => $this->string(1024),
            'thumbnail_path' => $this->string(1024),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'product_date' => $this->integer()->comment('Hạn của sản phẩm'),
            'product_time_use' => $this->integer()->comment('Thời gian dự tính sử dụng sản phẩm'),
            'is_notification' => $this->integer()->comment('Bật tắt thống báo sản phẩm hết hoặc gần hết'),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product');
        $this->dropTable('product_unit');
        $this->dropTable('product_type');
    }
}
