<?php

use yii\helpers\Html;
use app\modules\system\helpers\Cabinet;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model app\modules\system\models\users\Users */

$this->title = 'Изменить пользователя';
?>

<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('users');?>
        <div class="main-cabinet-content">
            <h2><?= Html::encode($this->title) ?></h2>

            <?php $form = ActiveForm::begin(); ?>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <?= $form->field($model, 'url', [
                        'template' => '<div>{label}</div><div>{input}</div><div class="text-danger">{error}</div>'
                    ])->textInput(['autofocus' => true, 'maxlength' => true, 'disabled' => true]); ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <?= $form->field($model, 'comment', [
                        'template' => '<div>{label}</div><div>{input}</div><div class="text-danger">{error}</div>'
                    ])->textInput(['maxlength' => true]); ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <?= $form->field($model, 'file')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/*', 'multiple' => true],
                    ]);?>
                </div>
            </div>



            <div class="form-group">
                <?= Html::submitButton('<i class="fa fa-save"></i> Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>
