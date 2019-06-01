<?php

use yii\db\Migration;

/**
 * Class m181123_071532_update_service_product_table
 */
class m181123_071532_update_service_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $this->alterColumn('service_product','amount',$this->decimal(10,2));
	    $this->addColumn('service','duration',$this->integer()->comment('Thời gian diễn ra'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    	$this->dropColumn('service','duration');
		return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181123_071532_update_service_product_table cannot be reverted.\n";

        return false;
    }
    */
}
