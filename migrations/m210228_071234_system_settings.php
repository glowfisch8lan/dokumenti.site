<?php

use yii\db\Migration;

/**
 * Class m210228_071234_system_settings
 */
class m210228_071234_system_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('system_settings', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
            'value' => $this->string(255)->notNull(),
            'user_id' => $this->integer(11)
        ]);


        $this->insert('system_settings', array('name'=>'system.cache.status','value'=>'true'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210228_071234_system_settings cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210228_071234_system_settings cannot be reverted.\n";

        return false;
    }
    */
}
