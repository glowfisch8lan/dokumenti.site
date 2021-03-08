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


        $this->insert('system_settings', array('name'=>'system.cache.status','value'=>'true', 'description' => 'Кеширование данных'));
        $this->insert('system_settings', array('name'=>'system.signup.group.default','value'=>'true', 'description' => 'Группа по-умолчанию при регистрации новых пользователей'));
        $this->insert('system_settings', array('name'=>'system.orders.sitetype.landingpage','value'=>'4 000', 'description' => 'Цена за Landing-page'));
        $this->insert('system_settings', array('name'=>'system.orders.sitetype.vizitka','value'=>'4 000', 'description' => 'Цена за Сайт-визитку'));
        $this->insert('system_settings', array('name'=>'system.orders.sitetype.magazine','value'=>'4 000', 'description' => 'Цена за Сайт-магазин'));
        $this->insert('system_settings', array('name'=>'system.orders.sitetype.forum','value'=>'4 000', 'description' => 'Цена за Форум'));

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
