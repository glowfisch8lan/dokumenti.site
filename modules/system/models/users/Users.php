<?php

namespace app\modules\system\models\users;



use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\modules\system\models\users\UsersBalance;
use app\modules\system\components\behaviors\CachedBehavior;

class Users extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $permissions;
    public $groups;

    protected $cache;

    /**
     * User constructor. Определяем в какой кеш будем сбрасывать данные
     */
    public function __construct()
    {
        $this->cache = Yii::$app->cacheUsers;
    }

    /**
     * Правила валидации
     *
     * @return array
     */
    public function rules(){
        return [
            [
                ['username', 'name', 'groups'],
                'required',
                'message' => 'Заполните поля!'
            ],
            [
                ['username', 'name', 'groups', 'password', 'phone'],
                'required',
                'message' => 'Заполните поля!',
                'on' => 'sign-up'
            ],
            ['username', 'unique', 'message' => 'Имя уже занято!'],
            ['phone', 'unique',  'message' => 'Укажите другой номер телефона!'],
            ['password', 'match', 'pattern' => '/[a-z0-9]*/', 'message' => 'Пароль не должен содержать пробелы'],

        ];
    }

    /**
     * Поведение перед сохранением в БД AR
     *
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            $this->password = ( empty($this->password) && Yii::$app->controller->action->id == 'update' ) ? $this->getOldAttribute('password') : Yii::$app->security->generatePasswordHash($this->password);
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes){

        /** Если в таблице users_balance нет записи о балансе - создаем ее с нулевым значением; */
        if(is_null(UsersBalance::findOne(['user_id' => $this->id])))
        {
            $balance = new UsersBalance();
            $balance->user_id = $this->id;
            $balance->value = 0;
            $balance->save();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Определяем поведение, очищающее кеш, при записи в БД AR
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'CachedBehavior' => [
                'class' => CachedBehavior::class,
                'cache' => Yii::$app->cacheUsers
            ]
        ];
    }

    /**
     * Устанавливаем аттрибуты
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'userGroup' => 'Группа',
            'name' => 'Фамилия, имя и отчество',
            'phone' => 'Телефон'
        ];
    }

    /**
     * Определяем таблицу, привязанную к моделе
     *
     * @return string
     */
    public static function tableName()
    {

        return 'system_users';
    }

    /**
     * Получить информацию о членстве пользователя в группах
     *
     * @param $user_id
     * @return array | ['group_id','user_username', 'group_name']
     */
    public static function getUserGroups($user_id)
    {

        $cache = Yii::$app->cacheUsers;
        $duration = 12000;

        /**
         * Кеширование
         */
        // $response = $cache->get('userGroupsMembers');
        $response = false;
        if ($response === false) {

            $response = (new \yii\db\Query())
                ->select('system_groups.id as id, system_users.username as username, system_groups.name as group ')
                ->from('system_users')
                ->join('LEFT JOIN', 'system_users_groups', 'system_users.id = system_users_groups.user_id')

                ->join('LEFT JOIN', 'system_groups', 'system_users_groups.group_id = system_groups.id')

                ->where('user_id = :user_id')
                ->addParams([':user_id' => (int) $user_id])
                //->createCommand()->queryAll( \PDO::FETCH_CLASS);
                ->all();
            $cache->set('userGroupsMembers', $response, $duration);
        }
        return $response;


    }

    /**
     * Получить список пользователей
     *
     * @return array
     * @throws \yii\db\Exception
     */
    public function getUserList(){

        return (new \yii\db\Query())
            ->select('
                `system_users`.`id` AS `id`,
                `system_users`.`username` AS `username`,
                `system_users`.`name` AS `name`

                ')
            ->from('system_users')
            //->join('LEFT JOIN', 'system_users', 'system_users_groups.user_id = system_users.id')
            ->createCommand()->queryAll( \PDO::FETCH_CLASS);

    }

    /**
     * Этот метод находит экземпляр identity class, используя ID пользователя. Этот метод используется, когда необходимо поддерживать состояние аутентификации через сессии.
     * @param int|string $id
     * @return User|IdentityInterface|null
     */
    public static function findIdentity($id){
        return static::findOne($id);
    }

    /**
     * Этот метод находит экземпляр identity class, используя токен доступа. Метод используется, когда требуется аутентифицировать пользователя только по секретному токену
     * (например в RESTful приложениях, не сохраняющих состояние между запросами).
     *
     * @param mixed $token
     * @param null $type
     * @return void|IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null){
    }

    /**
     * Установить пользователю новый пароль
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password){
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Поиск пользователя по логину
     *
     * @param $username
     * @return User|null
     */
    public static function findByUsername($username){
        return static::findOne(['username' => $username]);
    }

    /**
     * Этот метод возвращает ID пользователя, представленного данным экземпляром identity.
     *
     * @return int|mixed|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Этот метод возвращает ключ, используемый для основанной на cookie аутентификации. Ключ сохраняется в аутентификационной cookie и позже сравнивается с версией, находящейся на сервере,
     * чтобы удостоверится, что аутентификационная cookie верная.
     * @return string|void
     */
    public function getAuthKey(){
        //   return $this->authKey;
    }

    /**
     * Этот метод реализует логику проверки ключа для основанной на cookie аутентификации.
     *
     * @param string $authKey
     * @return bool|void
     */
    public function validateAuthKey($authKey){
        //    return $this->authKey === $authKey;
    }

    /**
     * Проверяет пароль по хешу.
     *
     * @param $password
     * @return bool|mixed
     * @throws \Adldap\Auth\BindException
     * @throws \Adldap\Auth\PasswordRequiredException
     * @throws \Adldap\Auth\UsernameRequiredException
     */
    public function validatePassword($password){
        /* Если пароль не хранится в локальной Базе, авторизуемся через LDAP */
//        if ($this->password == '' or $this->password == null) {
        if (1 != 1) {

            $result = Auth::getInstance()->process($this->username, $password);
            if($result)
            {
                Auth::getInstance()->syncUserGroups($this->username, $password);
            }

            return $result;

        } else {
            /* В ином случае проверяем пароль локально */

            return Yii::$app->security->validatePassword($password, $this->password);
        }
    }

    /**
     * Finds user by [[id]]
     *
     * @return Users |null
     */
    public static function getUser($id)
    {
        return Users::findOne($id);
    }

}
