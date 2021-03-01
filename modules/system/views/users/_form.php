<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\system\models\users\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-row">
        <div class="form-group col-md-12">
            <?= $form->field($model, 'name', [
                'template' => '<div>{label}</div><div>{input}</div><small>Введите имя пользователя</small><div class="text-danger">{error}</div>'
            ])->textInput(['autofocus' => true]); ?>

        </div>
        <div class="form-group col-md-6">
            <?= $form->field($model, 'username', [
                'template' => '<div>{label}</div><div>{input}</div><small>Введите логин пользователя</small>
                        <div class="text-danger">{error}</div>'
            ])->textInput(); ?>

        </div>

        <div class="form-group col-md-6">
            <?= $form
                ->field($model, 'password', [
                    'template' => '<div>{label}</div><div>{input}</div>
                             <small>Пожалуйста, придумайте пароль</small><div class="text-danger">{error}</div>'
                ])
                ->textInput(['autofocus' => true])
                ->passwordInput();
            ?>
        </div>

    </div>
    <div class="form-group">
        <?= $form
            ->field($model, 'userGroup', [
                'template' => '<div>{label}</div><div>{input}</div><div>{error}</div>
                             <small>Пожалуйста, выберите группу</small>'
            ])
            ->dropDownList(
                $model->allGroups,
                [
                    'options' => [
                        '2' => ['selected' => true],
                    ],
                ]
            );
        ?>
    </div>


    <div class="form-group">
        <?= Html::submitButton('<i class="fas fa-save"></i> Создать', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
