<?php

use yii\db\Migration;

/**
 * Class m210228_070939_system_users
 */
class m210228_070939_system_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('system_users', [
            'id' => $this->primaryKey(),
            'login' => $this->string(255)->notNull()->unique(),
            'name' => $this->string(255)->notNull(),
            'password' => $this->string(255)->notNull()
        ]);

        $this->insert('system_users', array('login'=>'admin','password'=>'$2y$13$srKMjyd5c.Z3QHdZd/.RXO7soqZ/ZQ4651XmcVSZ97tvxJYiUVPxi','name'=>'Администратор'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210228_070939_system_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210228_070939_system_users cannot be reverted.\n";

        return false;
    }
    */
}
