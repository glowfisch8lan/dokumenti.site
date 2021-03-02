<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use app\modules\system\helpers\Grid;
use app\modules\system\helpers\Cabinet;
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
                    'width' => 50,
                    'class' => 'text-center'
                ],
                'contentOptions' => ['class' => 'text-center'],
            ],
            'url:ntext',
            'sitetype',

    ]
];

/**
 * Если пользователь имеет на то право, показываем все учетные записи и выводим информацию о владельце заказа;
 *
 */
if(Yii::$app->user->identity->id === 1){
        $grid['columns'][] = [
                'attribute' => 'user_id'
        ];
}

$options =
    [
        'enableActionColumn' => false
    ];
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
