<?php

use yii\db\Migration;

/**
 * Handles the creation of table `employee_plan`.
 */
class m181228_143119_create_employee_plan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('CREATE TABLE `employee_plan` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `employee_id` int(11) DEFAULT NULL,
              `plan_date` date DEFAULT NULL,
              `start_time` time DEFAULT NULL,
              `end_time` time DEFAULT NULL,
              `status` smallint(6) NOT NULL DEFAULT 1,
              `created_at` int(11) DEFAULT NULL,
              `updated_at` int(11) DEFAULT NULL,
              `created_by` int(11) DEFAULT NULL,
              `updated_by` int(11) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
          ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('employee_plan');
    }
}
