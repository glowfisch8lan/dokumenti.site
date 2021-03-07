<?php

use yii\helpers\Html;
use app\modules\system\helpers\Cabinet;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\system\models\users\UsersOrders */

$this->title = 'Просмотр Заказа: #' . $model->id;
?>
<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('orders');?>
        <div class="main-cabinet-content">
            <h2><?= Html::encode($this->title) ?></h2>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'url',
                        'format' => 'raw',
                        'value' => function($data) {
                            return Html::a($data['url'], '//'.$data['url'],
                                [
                                    'class' => 'link',
                                    'target' => '_blank'
                                ]);
                        }
                    ],
                    'comment',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        /**
                         * 0 - не оплачено;
                         * 1 - оплачено;
                         */
                        'value' => function($data){
                            switch($data['status']){
                                case 0:
                                    $result = 'Не оплачено';
                                    if($data['user_id'] === Yii::$app->user->identity->id){
                                    $result = 'Не оплачено. ' . Html::a('Оплатить?', '#',
                                            [
                                                'class' => 'link',
                                                'data' => [
                                                    'method' => 'post'
                                                ]
                                            ]);
                                    }
                                    return $result;
                                case 1:
                                    return 'Оплачено';
                            }
                        }
                    ],
                    [
                        'label' => 'Файлы',
                        'format' => 'raw',
                        'value' => function($data) use($model){
                                $array = $model->getOrderFiles();
                                if(!$array)
                                    return 'Отсутствуют';
                                $code = null;
                                foreach($array as $tag => $files)
                                {
                                    foreach($files as $index => $file)
                                    {
                                        $code .= Html::a($file['filename'], '/system/files/get-file?uuid='.$file->tag.'&file='.$file->filename,
                                            [
                                                'class' => 'link',
                                                'data' => [
                                                    'method' => 'post'
                                                ]
                                            ]);
                                        $code .= '<br>';
                                    }
                                }

                                return $code;
                        }
                    ]
                ],
            ]) ?>

        </div>
    </div>
</section>
