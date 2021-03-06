<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\system\models\users\UsersOrders */

$this->title = 'Create Users Orders';
$this->params['breadcrumbs'][] = ['label' => 'Users Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-orders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
