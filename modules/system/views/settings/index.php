<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use app\modules\system\helpers\Grid;
use app\modules\system\helpers\Cabinet;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\system\models\settings\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Настройки';
/**
 * Выводим Верхнее меню;
 */
echo Cabinet::topMenu();
?>
<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('settings');?>
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
                        'attribute' => 'description',
                        'value' => function($data){
                            return
                                Html::a($data['description'], ['/system/settings/update', 'id' => $data['id']], ['class' => 'link']);
                        }
                    ],
                    'value:ntext',

                ],
                'ActionColumnHeader' => '&nbsp;',
                'buttonsOptions' => ['template' => '{edit}'],


            ],
                [
                    'enableActionColumn' => false
                ]);?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</section>
