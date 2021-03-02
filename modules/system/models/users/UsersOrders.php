<?php

namespace app\modules\system\models\users;

use Yii;
use app\modules\system\helpers\ArrayHelper;

/**
 * This is the model class for table "users_orders".
 *
 * @property int $id
 * @property string $url
 * @property int $sitetype
 */
class UsersOrders extends \yii\db\ActiveRecord
{

    public static $data = [
        [
            'id' => 1 ,
            'settings' => 'system.orders.sitetype.landingpage',
            'name' => 'Landing-page',
            'gid' => 'landing'
        ],
        [
            'id' => 2 ,
            'settings' => 'system.orders.sitetype.vizitka',
            'name' => 'Сайт-визитка',
            'gid' => 'visitka'
        ],
        [
            'id' => 2 ,
            'settings' => 'system.orders.sitetype.magazine',
            'name' => 'Интернет-магазин',
            'gid' => 'shop'

        ],
        [
            'id' => 3 ,
            'settings' => 'system.orders.sitetype.forum',
            'name' => 'Форум',
            'gid' => 'forum'
        ],

    ];

    public static function get($id)
    {
        return self::$data[ArrayHelper::recursiveArraySearch($id,self::$data)[0]];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'sitetype', 'user_id'], 'required'],
            [['url'], 'string'],
            [['sitetype'], 'integer'],
            [['user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'sitetype' => 'Site Type',
        ];
    }
}
