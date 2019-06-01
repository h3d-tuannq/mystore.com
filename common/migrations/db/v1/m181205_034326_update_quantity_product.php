<?php

use yii\db\Migration;

/**
 * Class m181205_034326_update_quantity_product
 */
class m181205_034326_update_quantity_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $this->alterColumn('product','quantity',$this->decimal());
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
        echo "m181205_034326_update_quantity_product cannot be reverted.\n";

        return false;
    }
    */
}
