<?php

namespace app\modules\system;

use app\modules\system\models\interfaces\modules\Modules;
use Yii;
use app\assets\SitesAsset;
use app\modules\system\models\rbac\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * system module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\system\controllers';
    public $visible = 'viewSystem';
    public $name = "Система";
    public $routes = [
        [
            'id' => 'order',
            'route' => '/system/default/order',
            'title' => '<i class="fas fa-plus-square"></i>&nbsp;Заказ документов',
            'access' => 'createOrder',
            'description' => 'Доступ к формированию заказа',
            'visible' => true
        ],
        [
            'id' => 'sites',
            'route' => '/system/default/sites',
            'title' => '<i class="fas fa-sitemap"></i>&nbsp;Мои сайты',
            'access' => 'viewSites',
            'description' => 'Доступ к списку заказов',
            'visible' => true
        ],
        [
            'id' => 'orders',
            'route' => '/system/default/orders',
            'title' => '<i class="fas fa-list-alt"></i>&nbsp;Список заказов',
            'access' => 'viewOrders',
            'description' => 'Доступ к состоянию заказов',
            'visible' => true
        ],
        [
            'id' => 'users',
            'route' => '/system/users',
            'title' => '<i class="fas fa-users"></i>&nbsp;Пользователи',
            'access' => 'viewUsers',
            'description' => 'Доступ к управлению пользователями',
            'visible' => true
        ],
        [
            'id' => 'groups',
            'route' => '/system/groups',
            'title' => '<i class="fas fa-users-cog"></i>&nbsp;Группы',
            'access' => 'viewGroups',
            'description' => 'Доступ к управлению группами',
            'visible' => true
        ],
        [
            'id' => 'settings',
            'route' => '/system/settings',
            'title' => '<i class="fas fa-cog"></i>&nbsp;Настройки',
            'access' => 'viewSettings',
            'description' => 'Доступ к настройкам',
            'visible' => true
        ]
    ];
    public $description = "Описание отсутствует";
    private $excludedRules;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Проверка доступа к определенному роуту модуля;
     *
     * @return bool
     * @throws ForbiddenHttpException
     * @throws \yii\web\ServerErrorHttpException
     */
    private function verifyAccess(){

        $act = '/' . Yii::$app->controller->module->id . '/' . Yii::$app->controller->id;


        if(empty($this->excludedRules))
            $this->excludedRules = [['route' => '', 'name' => '', 'module' => '']]; //Принудительно наполняем массив если он пустой;


        foreach($this->excludedRules as $eRule){
            if($eRule['route'] != $act){
                if(!\app\modules\system\models\rbac\AccessControl::checkAccess(Yii::$app->user->identity->id,$this->visible)){
                    throw new ForbiddenHttpException('You are not allowed to perform this action.');
                }

                //Провера доступа к подразделу модуля;
                $action = '/' . Yii::$app->controller->module->id . '/' . Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;
                $user_id = Yii::$app->user->identity->id;

                foreach($this->routes as $route){
                    if($route['route'] == $action) {
                        if(!AccessControl::checkAccess($user_id, $route['access']))
                            throw new ForbiddenHttpException('You are not allowed to perform this action.');

                    }
                }
            }
        }
        return false;
    }

    public function beforeAction($action)
    {

        /*
         *  Проверка регистрации модуля в системе: в случае отсутствия регистрации - выбросить исключение;
         */
        if(!Modules::checkRegister(Yii::$app->controller->module->id))
        {
            throw new ForbiddenHttpException('Модуль не зарегистрирован! Пожалуйста, зарегистрируйте модуль в системе.');
        }
        /*
         * Если пользователь неГость - проверка прав доступа к модулю | категории | действию;
         */
        (!(Yii::$app->user->isGuest)) ? $this->verifyAccess() : false;

        return parent::beforeAction($action);
    }
    public function init()
    {
        parent::init();
    }
}
