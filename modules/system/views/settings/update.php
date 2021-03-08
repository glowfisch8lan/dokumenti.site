<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use app\modules\system\helpers\Grid;
use app\modules\system\helpers\Cabinet;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\system\models\settings\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Редактирование настроек';
?>
<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('settings');?>
        <div class="main-cabinet-content">
            <h2><?= Html::encode($this->title) ?></h2>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</section>
