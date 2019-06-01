<?php

use yii\db\Migration;

/**
 * Class m181209_140809_update_order_table
 */
class m181209_140809_update_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE `order` CHANGE `discount` `discount` DECIMAL(10,2) NULL DEFAULT NULL COMMENT \'Chiết khấu cho khách hàng\';');
        $this->execute('ALTER TABLE `order` CHANGE `rate_receptionist` `rate_receptionist` DECIMAL(10,2) NULL DEFAULT \'0\' COMMENT \'Phần trăm hoa hồng cho lễ tân\';');
        $this->execute('ALTER TABLE `order` CHANGE `rate_receptionist_id` `rate_receptionist_id` INT NULL DEFAULT \'0\' COMMENT \'ID của nhân viên lễ tân\';');
        $this->execute('ALTER TABLE `order` CHANGE `rate_employee` `rate_employee` DECIMAL(10,2) NULL DEFAULT \'0\' COMMENT \'Phần trăm hoa hồng của nhân viên\';');
        $this->execute('ALTER TABLE `order` ADD `order_date` INT NOT NULL AFTER `code`;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181209_140809_update_order_table cannot be reverted.\n";

        return false;
    }
    */
}
