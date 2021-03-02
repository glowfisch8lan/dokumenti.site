<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\system\helpers\Cabinet;
use app\modules\system\helpers\Grid;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\system\models\users\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
?>

<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('users');?>
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

                    [
                        'format' => 'raw',
                        'attribute' => 'username',
                        'value' => function($data){
                            return
                                Html::a($data['username'], ['/system/users/update', 'id' => $data['id']], ['class' => 'link']);
                        }
                    ],
                    'name',
                    'phone:ntext',

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
                        return ($model['username'] == 'admin' || $model['id'] == 1) ? null : Html::a('<i class="fas fa-trash" aria-hidden="true"></i>', $url,
                            ['class' => 'btn btn-outline-danger',
                                'data' => [
                                    'confirm' => 'Вы действительно хотите удалить данную позицию?',
                                    'method' => 'post'
                                ]]);
                            },
                    ],
//                'ActionColumnHeader' => '&nbsp;',
                'buttonsOptions' => ['template' => '{edit} {delete}'],


            ]);?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</section>
