<?php

use yii\db\Migration;

/**
 * Class m181206_161925_update_activity
 */
class m181206_161925_update_activity extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('activity','discount',$this->decimal());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('activity','discount');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181206_161925_update_activity cannot be reverted.\n";

        return false;
    }
    */
}
