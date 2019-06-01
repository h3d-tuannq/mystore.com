<?php

use yii\db\Migration;

/**
 * Handles the creation of table `service_product`.
 */
class m181119_134454_create_service_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('service_product', [
            'id' => $this->primaryKey(),
            'service_id' => $this->integer(),
            'product_id' => $this->integer()->defaultValue(1)->comment('Hình thức thanh toán'),
            'amount' => $this->integer()->unsigned()->defaultValue(0)->comment('Số lượng'),
            'unit' => $this->string()->comment('Đơn vị'),
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
        $this->dropTable('service_product');
    }
}
