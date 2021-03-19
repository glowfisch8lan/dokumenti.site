<?php

use yii\helpers\Html;
use app\modules\system\helpers\Cabinet;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\widgets\DetailView;
use app\modules\system\models\users\UsersOrders;

/* @var $this yii\web\View */
/* @var $model app\modules\system\models\users\UsersOrders */

$this->title = 'Изменение Заказа: #' . $model->id;
/**
 * Выводим Верхнее меню;
 */
echo Cabinet::topMenu();
?>
<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('orders');?>
        <div class="main-cabinet-content">
            <h2 class="h2 title"><?= Html::encode($this->title) ?></h2>
        <div class="main-form">
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
                    ])->textarea(['maxlength' => true, 'row' => 6]); ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <?= $form->field($model, 'stage', [
                        'template' => '<div>{label}</div><div>{input}</div><div class="text-danger">{error}</div>'
                    ])->dropDownList(
                            [
                                UsersOrders::WAIT_FOR_PAYMENT => 'Ожидает оплаты',
                                UsersOrders::IN_WORK => 'В работе',
                                UsersOrders::WORK_DONE => 'Выполнено',
                            ]
                    ); ?>
                </div>
            </div>


            <div class="form-row">
                <div class="form-group col-md-12">
                    <span>Вы можете загрузить несколько файлов формата doc(x), pdf</span>
                    <?= $form->field($model, '_files')->widget(FileInput::classname(), ['options' => ['multiple' => true]])->label('');?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton('<i class="fa fa-save"></i> Cохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>

        </div>
    </div>
</section>
