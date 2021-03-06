<?php

use app\modules\system\models\rbac\AccessControl;
use yii\helpers\Html;
use yii\widgets\Pjax;
use app\modules\system\helpers\Grid;
use app\modules\system\helpers\Cabinet;
use app\modules\system\models\users\Users;
use app\modules\system\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\system\models\users\UsersOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заявки';

/**
 * Выводим Верхнее меню;
 */
echo Cabinet::topMenu();

/**
 * Определяем стандартные параметры для хелпера GridView. По ходу выполнения в зависимости от разрешений пользователя - будем переопределять данные в массиве;
 */
$grid = [
        'dataProvider' => $dataProvider,
        'columns' => [

            /**
             * Колонка "Идентификатор"
             */
            [   'attribute' => 'id',
                'label' => 'Идентификатор',
                'headerOptions' => [
                    'width' => 50,
                    'class' => 'text-center'
                ],
                'contentOptions' => ['class' => 'text-center'],
            ],

            /**
             * Колонка "Адрес Сайта"
             */
            [   'attribute' => 'url',
                'label' => 'Адрес сайта',
                'format' => 'raw',
                'value' => function($data){
                        return $data['url'];
                }
            ],

            /**
             * Колонка "Тип сайта"
             */
            [   'attribute' => 'sitetype',
                'label' => 'Тип сайта',
                'format' => 'raw',

                /**
                 * Преобразует ID наименования Типа сайта в Строку;
                 */
                'value' => function($data){
                    return
                        \app\modules\system\models\users\UsersOrders::getSiteType($data['sitetype'])['name'];
                }
            ],

            /**
             * Колонка "Статус платежа"
             */
            [   'attribute' => 'status',
                'label' => 'Статус платежа',
                'format' => 'raw',

                /**
                 * 0 - не оплачено;
                 * 1 - оплачено;
                 */
                'value' => function($data){
                    switch($data['status']){
                        case 0:
                            return 'Не оплачено';
                        case 1:
                            return 'Оплачено';
                    }
                }
            ],

            /**
             * Колонка "Этап выполнения"
             */
            [   'attribute' => 'stage',
                'label' => 'Этап выполнения',
                'format' => 'raw',

                /**
                 * 0 - В работе;
                 * 1 - Выполнено;
                 */
                'value' => function($data){
                    switch($data['stage']){
                        case 0:
                            return '<span class="text-info font-weight-bold">В работе</span>';
                        case 1:
                            return '<span class="text-success font-weight-bold">Выполнено</span>';
                    }
                }
            ],
        ],
];
/**
 * ЯЧейка-шапка колонки "Кнопки-действия"
 */
$grid['ActionColumnHeader'] = '&nbsp;';
/**
 * Шаблон колонки "Кнопки-действия"
 */
$grid['buttonsOptions'] = ['template' => '{view} {delete}'];

/**
 * Выключаем ActionColumn для обычного пользователя
 */
$options = ['enableActionColumn' => true];

/**
 * Grid для Модераторов
 */
if(AccessControl::checkAccess(
        Yii::$app->user->identity->id,
        ArrayHelper::getDataById(Yii::$app->getModule('system')->routes, 'all-user-orders')['access']
    ))
{

    /**
     * Включаем ActionColumn
     */
    $options = ['enableActionColumn' => true];

    /**
     * Колонка "Кнопки-действия"
     */
    $grid['ActionColumnButtons'] = [
        'locking' => function ($url,$model) {
            $locking = (!$model['locking']) ? 'fa-lock-open' : 'fa-lock';
            $disabled = ($model['locking'] != Yii::$app->user->identity->id && $model['locking']) ? ' disabled' : null;
            $_span = ($disabled) ? '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Заблокировано '.Users::getUser($model['locking'])->username.'">' : '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Разблокировано">';

            return $_span.
                Html::a('<i class="fas '.$locking.'"></i>', $url,
                [
                    'class' => 'btn btn-outline-info'.$disabled,
                    'data' => [
                        'method' => 'post'
                    ]
                ]) . '</span>';
        },
        'view' => function ($url,$model) {
            return
                Html::a('<i class="fas fa-eye"></i>', $url,
                    [
                        'class' => 'btn btn-outline-info',
                        'data' => [
                            'method' => 'post'
                        ]
                    ]);
        },
        'update' => function ($url,$model) {

        if($model['locking'] != Yii::$app->user->identity->id){
            return;
        }

        $locking = (!$model['locking']) ? 'fa-pencil-alt' : 'fa-pencil-alt';
        $disabled = ($model['locking'] != Yii::$app->user->identity->id && $model['locking']) ? ' disabled' : null;

        return
            Html::a('<i class="fas fa-pencil-alt"></i>', $url,
                [
                    'class' => 'btn btn-outline-danger '.$disabled,
                    'data' => [
                        'method' => 'post'
                    ]
                ]);
    }
    ];

    /**
     * ЯЧейка-шапка колонки "Кнопки-действия"
     */
    $grid['ActionColumnHeader'] = '&nbsp;';

    /**
     * Шаблон колонки "Кнопки-действия"
     */
    $grid['buttonsOptions'] = ['template' => '{view} {update} {locking}'];
    $grid['buttonsOptions']['headerWidth'] = '200';
    /**
     * Колонка "Владелец заказа"
     */
    $grid['columns'][] = [
        'attribute' => 'user_id',
        'value' => function($model){return Users::getUser($model->user_id)->name;}
    ];
}

?>

<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('orders');?>
        <div class="main-cabinet-content">
            <div class="main-cabinet-orders">
                <h2 class="h2 title">Список заказов</h2>

                <?php Pjax::begin(); ?>
                <?= Grid::initWidget( $grid, $options );?>
                <?php Pjax::end(); ?>

<!--                <div class="main-cabinet-orders__item">-->
<!--                    <p class="title">Оплата пакета “Landing-page” для example2.ru</p>-->
<!--                    <p class="summ">Сумма платежа: <span>3000 ₽</span></p>-->
<!--                    <p class="status">Статус: <span class="wait">Ожидает оплаты</span></p>-->
<!--                </div>-->
<!--                -->
<!--                <div class="main-cabinet-orders__item">-->
<!--                    <p class="title">Пакет “Landing-page” для example2.ru оплачен</p>-->
<!--                    <p class="summ">Сумма платежа: <span>3000 ₽</span></p>-->
<!--                    <p class="status">Статус: <span class="success">Оплачено</span></p>-->
<!--                </div>-->
<!--                -->
<!--                <div class="main-cabinet-orders__item">-->
<!--                    <p class="title">Оплата example2.ru отменена</p>-->
<!--                    <p class="summ">Сумма платежа: <span>3000 ₽</span></p>-->
<!--                    <p class="status">Статус: <span class="canceled">Отменено</span></p>-->
<!--                </div>-->

            </div>
        </div>
    </div>
</section>
