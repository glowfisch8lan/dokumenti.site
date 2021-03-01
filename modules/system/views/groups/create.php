<?php

use yii\helpers\Html;
use app\modules\system\helpers\Cabinet;
/* @var $this yii\web\View */
/* @var $model app\modules\system\models\users\Groups */

$this->title = 'Создать группу';
?>
<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('groups');?>
        <div class="main-cabinet-content">
            <h2><?= Html::encode($this->title) ?></h2>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</section>
