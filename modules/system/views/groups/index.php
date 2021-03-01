<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use app\modules\system\helpers\Grid;
use app\modules\system\helpers\Cabinet;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\system\models\users\GroupsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Группы';
?>

<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('groups');?>
        <div class="main-cabinet-content">
            <h2><?= Html::encode($this->title) ?></h2>

            <?php Pjax::begin(); ?>
            <?= Grid::initWidget([
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
                    'name',
                    'description'

                ],
                'ActionColumnButtons' =>
                    [
                        'update' => function ($url,$model) {
                            return Html::a('<i class="fas fa-pencil-alt" aria-hidden="true"></i>', $url,
                                ['class' => 'btn btn-outline-info',
                                    'data' => [
                                        'method' => 'post'
                                    ]]);
                        },

                        'delete' =>
                            function($url, $model){
                                return ($model['name'] == 'Администраторы' || $model['id'] == 1) ? null : Html::a('<i class="fas fa-trash" aria-hidden="true"></i>', $url,
                                    ['class' => 'btn btn-outline-danger',
                                        'data' => [
                                            'confirm' => 'Вы действительно хотите удалить данную позицию?',
                                            'method' => 'post'
                                        ]]);
                            },
                    ],
                'buttonsOptions' => ['template' => '{view} {update} {delete}', 'headerWidth' => 200],
            ]);?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</section>

