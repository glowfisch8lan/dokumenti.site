<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\system\helpers\Cabinet;
/* @var $this yii\web\View */
/* @var $model app\modules\system\models\users\Users */

$this->title = 'Просмор пользователя ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
/** Выводим Верхнее меню; */
echo Cabinet::topMenu();
?>
<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('users');?>
        <div class="main-cabinet-content">

            <div class="users-view">
                <h2><?= Html::encode($this->title) ?></h2>
                <p>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'username',
                        'name',
                        'password',
                        'phone:ntext',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</section>

