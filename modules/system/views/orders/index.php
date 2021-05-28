<?php
/**
 * Список заказов
 */
use app\modules\system\models\rbac\AccessControl;
use yii\helpers\Html;
use yii\widgets\Pjax;
use app\modules\system\helpers\Grid;
use app\modules\system\helpers\Cabinet;
use app\modules\system\models\users\Users;
use app\modules\system\helpers\ArrayHelper;
use app\modules\system\models\users\UsersOrders;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\system\models\users\UsersOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список заказов';

/**
 * Выводим Верхнее меню;
 */
echo Cabinet::topMenu();

/** Определяем стандартные параметры для хелпера GridView. По ходу выполнения в зависимости от разрешений пользователя - будем переопределять данные в массиве; */
$grid = [
        'dataProvider' => $dataProvider,
        'columns' => [

            [
                'label' => '',
                'format' => 'raw',
                'value' => function($data){
                    return 'Заказ #' . $data['id'] . ' для пакета "' . \app\modules\system\models\users\UsersOrders::getSiteType($data['sitetype'])['name'] . '"';
                    }
            ],

            /** Колонка "Статус платежа" */
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
                            //return '<span class="text-danger font-weight-bold">Не оплачено&nbsp;</span>'.
                                return Html::a('Оплатить', ['/system/payment/pay', 'order_id' => $data['id']],
                                    [
                                        'class' => 'link',
                                        'data' => [
                                            'method' => 'post',
                                            'confirm' => 'Вы уверены, что хотите оплатить данный заказ?'
                                        ]
                                    ]);
                        case 1:
                            return '<span class="text-success font-weight-bold">Оплачено</span>';
                    }
                }
            ],

            /** Колонка "Идентификатор" */
/*            [   'attribute' => 'id',
                'label' => 'Идентификатор',
                'headerOptions' => [
                    'width' => 50,
                    'class' => 'text-center'
                ],
                'contentOptions' => ['class' => 'text-center'],
            ],*/

            /** Колонка "Адрес Сайта" */
/*            [   'attribute' => 'url',
                'label' => 'Адрес сайта',
                'format' => 'raw',
                'value' => function($data){
                        return $data['url'];
                }
            ],*/

            /** Колонка "Тип сайта" */
//            [   'attribute' => 'sitetype',
//                'label' => 'Тип сайта',
//                'format' => 'raw',
//                /** Преобразует ID наименования Типа сайта в Строку; */
//                'value' => function($data){
//                    return
//                        \app\modules\system\models\users\UsersOrders::getSiteType($data['sitetype'])['name'];
//                }
//            ],

            /** Колонка "Стоимость заказа" */
//            [   'attribute' => 'coast',
//                'label' => 'Стоимость заказа',
//                'format' => 'raw',
//                'value' => function($data){return $data['coast'] . ' руб.';}
//                /**
//                 * Преобразует ID наименования Типа сайта в Строку;
//                 */
//
//            ],
        ],
];

/** Колонка "Этап выполнения" */
$userGroups = (\app\modules\system\models\users\Users::getUserGroups(Yii::$app->user->identity->id));
foreach($userGroups as $groupKey => $group)
{
    if( $group['id'] == 2 )
    {
        $grid['columns'][] =
            [   'attribute' => 'stage',
                'label' => 'Этап выполнения',
                'format' => 'raw',
                /**
                 * 0 - В работе;
                 * 1 - Выполнено;
                 */
                'value' => function($data){
                    switch($data['stage']){
                        case UsersOrders::WAIT_FOR_PAYMENT:
                            return '<span class="text-warning font-weight-bold">Ожидает оплаты</span>';
                        case UsersOrders::IN_WORK:
                            return '<span class="text-info font-weight-bold">В работе</span>';
                        case UsersOrders::WORK_DONE:
                            return '<span class="text-success font-weight-bold">Выполнено</span>';
                    }
                }
            ];
    }
}

/** Включаем ActionColumn для обычного пользователя */
$options = ['enableActionColumn' => true, 'showHeader' => false];

/** Ячейка-шапка колонки "Кнопки-действия */
$grid['ActionColumnHeader'] = '&nbsp;';

/** Шаблон колонки "Кнопки-действия" */
$grid['buttonsOptions'] = ['template' => '{view}'];

/** Grid для Модераторов */
if( AccessControl::checkAccess( Yii::$app->user->identity->id, ArrayHelper::getDataById(Yii::$app->getModule('system')->routes, 'all-user-orders')['access'] ))
{

    /** Включаем ActionColumn */
    $options = ['enableActionColumn' => true];

    /** Колонка "Кнопки-действия" */
    $grid['ActionColumnButtons'] = [
        'locking' => function ($url,$model) {
            $locking = (!$model['locking']) ? 'fa-lock-open' : 'fa-lock';
            $disabled = ($model['locking'] != Yii::$app->user->identity->id && $model['locking']) ? true : false;
           // $_span = ($disabled) ? '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Заблокировано '.Users::getUser($model['locking'])->username.'">' : '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Разблокировано">';
            $_span = ($disabled) ? '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Заблокировано '.Users::getUser($model['locking'])->username.'">' : '<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Разблокировано">';

            if($disabled)
            {
                return
                    Html::tag('a','<i class="fas '.$locking.'"></i>',
                        [
                            'class' => 'btn'
                        ]);
            }

           // return $_span.
            return
                Html::a( '<i class="fas '.$locking.'"></i>', $url,
                [
                    'class' => 'btn',
                    'disabled' => true,
                    'data' => [
                        'method' => 'post'
                    ]
                ]) ;
                //. '</span>';
        },
        'view'    => function ($url,$model) {
            return
                Html::a('<i class="fas fa-eye"></i>', $url,
                    [
                        'class' => 'btn',
                        'data' => [
                            'method' => 'post'
                        ]
                    ]);
        },
        'update'  => function ($url,$model) {

        if($model['locking'] != Yii::$app->user->identity->id && Yii::$app->user->identity->id != 1){
            return;
        }

        $locking = (!$model['locking']) ? 'fa-pencil-alt' : 'fa-pencil-alt';
        $disabled = ($model['locking'] != Yii::$app->user->identity->id && $model['locking'] && Yii::$app->user->identity->id != 1) ? true : false;

        if($disabled)
        {
            return
                Html::tag('span','<i class="fas fa-pencil-alt"></i>',
                    [
                        'class' => 'btn'
                    ]);
        }

        return
            Html::a('<i class="fas fa-pencil-alt"></i>', $url,
                [
                    'class' => 'btn',
                    'data' => [
                        'method' => 'post'
                    ]
                ]);
        },
        'delete'  => function ($url,$model) {

            if($model['locking'] || Yii::$app->user->identity->id != 1){
                return;
            }

            return
                Html::a('<i class="fas fa-trash"></i>', $url,
                    [
                        'class' => 'btn',
                        'data' => [
                            'method' => 'post'
                        ]
                    ]);
        }
    ];

    /** Ячейка-шапка колонки "Кнопки-действия"*/
    $grid['ActionColumnHeader'] = '&nbsp;';

    /** Шаблон колонки "Кнопки-действия"*/
    $grid['buttonsOptions'] = ['template' => '{view}{update}{locking}'];
    $grid['buttonsOptions']['headerWidth'] = 280;

    /** Колонка "Владелец заказа" */
    $arr = [
        'attribute' => 'user_id',
        'value' => function($model){return Users::getUser($model->user_id)->name;}
    ];
    array_unshift($grid['columns'], $arr);
}

/**
 * Вывод кнопки удаления заказа по наличию разрешения;
 */
if( AccessControl::checkAccess( Yii::$app->user->identity->id, ArrayHelper::getDataById(Yii::$app->getModule('system')->routes, 'orders-delete')['access'] ))
{
    $grid['buttonsOptions']['template'] = $grid['buttonsOptions']['template'] . '{delete}';
}
?>
<style>
    .table {
        border: 5px solid #fff !important;
        background-color: #fff;
        font-size:16px;
    }
    .table th, .table td {
        border: 0px !important;
        vertical-align: middle;
    }
    .table tr {
        border: 10px solid #fff !important;
        background-color: #F2F2F2;
    }
    td > a.btn
    {
        min-width:44px;
    }
    @media screen and (max-width: 600px) {
        table tr{
            display: block;
        }
        table tr{
            margin-bottom: 30px;
        }
        table th, table td{
            display: block;
            text-align: center;
        }
    }

</style>
<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('orders');?>
        <div class="main-cabinet-content">
            <div class="main-cabinet-orders">
                <h2 class="h2 title"><?= Html::encode($this->title) ?></h2>

                <?php Pjax::begin(); ?>
                <?= Grid::initWidget( $grid, $options );?>
                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
</section>
