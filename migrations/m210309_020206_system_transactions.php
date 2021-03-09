<?php

use yii\db\Migration;

/**
 * Class m210309_020206_system_transactions
 */
class m210309_020206_system_transactions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName != 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('system_transactions', [
            'id' => $this->primaryKey(),
            'tb_payment_id' => $this->integer(),
            'tb_card_id' => $this->integer(),
            'tb_pan' => $this->string(16),
            'tb_exp_date' => $this->string(4),
            'tb_token' => $this->text(),
            'tb_amount' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addColumn('system_transactions', 'user_id', $this->integer());

        $this->addForeignKey(
            'transaction_user_fk',
            'system_transactions',
            'user_id',
            'system_users',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210309_020206_system_transactions cannot be reverted.\n";
        $this->dropTable('{{%transactions}}');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210309_020206_system_transactions cannot be reverted.\n";

        return false;
    }
    */
}
