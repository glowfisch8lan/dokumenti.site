<?php

use yii\db\Migration;

/**
 * Class m210308_072810_users_balance
 */
class m210308_072810_users_balance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users_balance', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull()->unique(),
            'value' => $this->string(255)->notNull(),
        ]);

        $this->createIndex('users_balance_user_index', 'users_balance','user_id');

        $this->addForeignKey('users_balance_user_', 'users_balance', 'user_id', 'system_users', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210308_072810_users_balance cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210308_072810_users_balance cannot be reverted.\n";

        return false;
    }
    */
}
