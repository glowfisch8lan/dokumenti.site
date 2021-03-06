<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\file\FileInput;

use app\modules\system\helpers\Grid;
use app\modules\system\helpers\Cabinet;
use app\modules\system\models\users\Users;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\system\models\users\UsersOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заявки';


echo Cabinet::topMenu();

$grid = [
    'dataProvider' => $dataProvider,
    'columns' => [
        [   'attribute' => 'id',
            'label' => 'Идентификатор',
            'headerOptions' => [
                'width' => 25,
                'class' => 'text-center'
            ],
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'url',
            'label' => 'Адрес сайта',
            'format' => 'raw',
            'value' => function($data){
                return
                    Html::a($data['url'], ['/system/lawyer/update', 'id' => $data['id']], ['class' => 'link']);
            }
        ],
        [   'attribute' => 'sitetype',
            'label' => 'Тип сайта',
            'format' => 'raw',
            'value' => function($data){
                return
                    \app\modules\system\models\users\UsersOrders::getSiteType($data['sitetype'])['name'];
            }
        ],
    ],
    'ActionColumnButtons' =>
        [
            'locking' => function ($url,$model) {

                $locking = (!$model['locking']) ? 'fa-lock-open' : 'fa-lock';
                $disabled = ($model['locking'] != Yii::$app->user->identity->id && $model['locking']) ? ' disabled' : '';
                return Html::a('<i class="fas '.$locking.'"></i>', $url,
                    ['class' => 'btn btn-outline-info'.$disabled,
                        'data' => [
                            'method' => 'post'
                        ]]);
            }
        ],
     'ActionColumnHeader' => '&nbsp;',
    'buttonsOptions' => ['template' => '{locking}'],
];

/**
 * Если пользователь имеет на то право, показываем все учетные записи и выводим информацию о владельце заказа;
 *
 */
if(Yii::$app->user->identity->id === 1){
    $grid['columns'][] = [
        'attribute' => 'user_id',
        'value' => function($model){return Users::getUser($model->user_id)->name;}
    ];
}

$options =
    [
        'enableActionColumn' => true
    ];
?>

<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('lawyer-orders');?>
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
