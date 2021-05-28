<?php

use yii\db\Migration;

/**
 * Class m210228_071022_system_users_groups
 */
class m210231_071022_system_users_groups extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('system_users_groups', [
            'user_id' => $this->integer(11)->notNull(),
            'group_id' => $this->integer(11)->notNull(),
        ]);

        $this->createIndex('system_users_groups_user_index', 'system_users_groups','user_id');
        $this->createIndex('system_users_groups_group_index', 'system_users_groups','group_id');
        $this->createIndex('system_users_groups_full_index', 'system_users_groups','group_id, user_id', true);

        $this->addForeignKey('system_users_groups_group', 'system_users_groups', 'group_id', 'system_groups', 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKey('system_users_groups_user', 'system_users_groups', 'user_id', 'system_users', 'id', 'CASCADE', 'CASCADE');
        $this->insert('system_users_groups', array('user_id' => 1, 'group_id' => 1));
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210228_071022_system_users_groups cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210228_071022_system_users_groups cannot be reverted.\n";

        return false;
    }
    */
}
