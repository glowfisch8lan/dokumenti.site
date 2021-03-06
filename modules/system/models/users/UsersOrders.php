<?php

namespace app\modules\system\models\users;

use Yii;
use app\modules\system\helpers\ArrayHelper;
use app\modules\system\models\files\Files;

/**
 * This is the model class for table "users_orders".
 *
 * @property int $id
 * @property string $url
 * @property int $sitetype
 */
class UsersOrders extends \yii\db\ActiveRecord
{

    public $_files;

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
            [['stage'], 'integer'],
            [['comment', 'locking', 'tag'], 'safe'],
            [['_files'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Адрес сайта',
            'sitetype' => 'Тип сайта',
            'user_id' => 'Пользователь',
            'comment' => 'Комментарий',
            'status' => 'Статус платежа',
            'stage'  => 'Стадия выполнения'
        ];
    }

    /**
     * Получить данные о категории сайта по ID из массива $data;
     *
     * @param $id
     * @return mixed
     */
    public static function getSiteType($id)
    {
        return self::$data[ArrayHelper::recursiveArraySearch($id,self::$data)[0]];
    }

    /**
     * Получить файлы пользователя;
     */
    public function getOrderFiles()
    {
        foreach(json_decode($this->tag) as $key => $value)
        {
            $arr[] = Files::getFilesByTag($value);
        }

        return $arr;


    }
}
