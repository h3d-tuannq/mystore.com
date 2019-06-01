<?php

use yii\db\Migration;

/**
 * Class m190109_153047_update_employee_table
 */
class m190109_153047_update_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('employee_type', ['slug' => 'le-tan', 'name' => 'Lễ tân', 'description' => 'Lễ tân', 'created_at' => time(), 'updated_at' => time()]);
        $this->addColumn('employee','employee_type_id',$this->integer()->defaultValue(1));
        $this->addColumn('employee','color',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('employee','employee_type_id');
        $this->dropColumn('employee','color');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190109_153047_update_employee_table cannot be reverted.\n";

        return false;
    }
    */
}
