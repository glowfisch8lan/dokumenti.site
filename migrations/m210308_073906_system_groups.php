<?php

use yii\db\Migration;

/**
 * Class m210308_073906_system_groups
 */
class m210308_073906_system_groups extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('system_groups', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
            'description' => $this->string(255)->notNull(),
            'permissions' => $this->string(255)->notNull(),
        ]);
        $this->insert('system_groups', array('name'=>'Администратор','description'=>'Администраторы системы','permissions'=>'["viewSystem","readSystemModules","viewSystemUpdates","viewUsers","viewGroups"]'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210308_073906_system_groups cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210308_073906_system_groups cannot be reverted.\n";

        return false;
    }
    */
}
