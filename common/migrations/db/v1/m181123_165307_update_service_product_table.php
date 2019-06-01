<?php

use yii\db\Migration;

/**
 * Class m181123_165307_update_service_product_table
 */
class m181123_165307_update_service_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('service_product','sort','integer');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('service_product','sort');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181123_165307_update_service_product_table cannot be reverted.\n";

        return false;
    }
    */
}
