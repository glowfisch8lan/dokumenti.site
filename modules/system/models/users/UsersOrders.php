<?php

namespace app\modules\system\models\users;

use Yii;
use app\modules\system\helpers\ArrayHelper;
use app\modules\system\models\files\Files;
use app\modules\system\models\settings\Settings;
use yii\behaviors\TimestampBehavior;

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

    const STATUS_ORDER_PAY_AWAITS = 0; //Ожидание оплаты заказа;
    const STATUS_ORDER_PAID = 1; //Заказ оплачен;

    const PAYMENT_TYPE_CARD = 1;
    const PAYMENT_TYPE_ACCOUNT = 2;
    const PAYMENT_TYPE_INVOICE = 3;

    const WAIT_FOR_PAYMENT = 0;
    const IN_WORK = 1;
    const WORK_DONE = 2;


    /**
     * Типы сайтов для заказа;
     * @var array
     */
    public static $data = [
        [
            'id' => 1 ,
            'settings' => 'system.orders.sitetype.landingpage',
            'name' => 'Сайт Визитка / Лэндинг',
            'gid' => 'landing',
            'html' => '
                <ul>
                    <li><span>Пользовательское соглашение</span></li>
                    <li><span>Политика конфиденциальности</span></li>
                    <li><span>Обработка персональных данных</span></li>
                    <li><span>Уведомление об использовании технологий</span></li>
                    <li><span>Установка документов на сайт</span></li>
                    <li><span>Установка технических уведомлений на сайт</span></li>
                </ul>'
        ],
        [
            'id' => 2 ,
            'settings' => 'system.orders.sitetype.catalog',
            'name' => 'Интернет - каталог',
            'gid' => 'catalog',
            'html' => '<ul>
                    <li><span>Пользовательское соглашение</span></li>
                    <li><span>Политика конфиденциальности</span></li>
                    <li><span>Обработка персональных данных</span></li>
                    <li><span>Уведомление об использовании технологий</span></li>
                    <li><span>Договор оферта</span></li>
                    <li><span>Установка документов на сайт</span></li>
                    <li><span>Установка технических уведомлений на сайт</span></li>
                </ul>'
        ],
        [
            'id' => 3 ,
            'settings' => 'system.orders.sitetype.magazine',
            'name' => 'Интернет - магазин',
            'gid' => 'shop',
            'html' => '<ul>
                    <li><span>Пользовательское соглашение</span></li>
                    <li><span>Политика конфиденциальности</span></li>
                    <li><span>Обработка персональных данных</span></li>
                    <li><span>Уведомление об использовании технологий</span></li>
                    <li><span>Договор оферта</span></li>
                    <li><span>Установка документов на сайт</span></li>
                    <li><span>Установка технических уведомлений на сайт</span></li>
                </ul>'

        ],
        [
            'id' => 4 ,
            'settings' => 'system.orders.sitetype.service',
            'name' => 'Интернет - сервис',
            'gid' => 'service',
            'html' => '<ul>
                    <li><span>Пользовательское соглашение</span></li>
                    <li><span>Политика конфиденциальности</span></li>
                    <li><span>Обработка персональных данных</span></li>
                    <li><span>Уведомление об использовании технологий</span></li>
                    <li><span>Дополнительные документы разрабатываются индивидуально в зависимости от типа сайта и бизнеса</span></li>
                </ul>'
        ],

    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_orders';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'sitetype', 'user_id'], 'required'],
            [['url'], 'string'],
            ['url', 'url', 'pattern'=>'/(([A-я0-9][A-я0-9_-]*)(\.[A-я0-9][A-я0-9_-]*)+)(?::\d{1,5})?(?:$|[?\/#])/i'],
            [['sitetype'], 'integer'],
            [['user_id'], 'integer'],
            [['stage'], 'integer'],
            [['comment', 'locking', 'tag'], 'safe'],
            [['coast'], 'safe'],
            ['_files', 'file', 'extensions' => ['pdf', 'doc', 'docx']],
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
            'stage'  => 'Стадия выполнения',
            '_files' => 'Документы',
            'coast' => 'Стоимость заказа'

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
     *
     * @return bool | Array
     */
    public function getOrderFiles()
    {

        if($this->tag){
            $tags = json_decode($this->tag);
            foreach($tags as $key => $value)
                $arr[$value] = Files::getFilesByTag($value);
            return $arr;
        }

        return false;
    }

    /**
     * Получить расчет стоимости заказа;
     * Поиск в статическом массиве  $data информации о типе сайта в заказе, затем получаем значение настройки,
     * где хранится цена за заказ такого типа сайта, получаем стоимость и возвращаем.
     * Фильтрация от пробелов и других символов, так как в настройки мы пишем любую строку.
     *
     * @return int
     */
    public function getCoastOrder()
    {
        $setting = self::$data[ArrayHelper::recursiveArraySearch($this->sitetype,self::$data)[0]]['settings'];
        return intval(preg_replace('/[^0-9]/', '', Settings::getValue($setting)));
    }
}
