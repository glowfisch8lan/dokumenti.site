<?php

use yii\db\Migration;

/**
 * Class m210309_044254_alter_system_transactions
 */
class m210309_044254_alter_system_transactions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('system_history', 'transaction_id', $this->integer());

        $this->addForeignKey(
            'history_transaction_fk',
            'system_history',
            'transaction_id',
            'system_transactions',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210309_044254_alter_system_transactions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210309_044254_alter_system_transactions cannot be reverted.\n";

        return false;
    }
    */
}
