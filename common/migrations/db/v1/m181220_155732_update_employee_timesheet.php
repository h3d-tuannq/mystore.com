<?php

use yii\db\Migration;

/**
 * Class m181220_155732_update_employee_timesheet
 */
class m181220_155732_update_employee_timesheet extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE `employee_timesheet` CHANGE `start_time` `start_time` TIME NULL DEFAULT NULL;');
        $this->execute('ALTER TABLE `employee_timesheet` CHANGE `end_time` `end_time` TIME NULL DEFAULT NULL;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181220_155732_update_employee_timesheet cannot be reverted.\n";

        return false;
    }
    */
}
