<?php

use yii\helpers\Html;
use app\modules\system\helpers\Cabinet;
use yii\widgets\ActiveForm;
use app\modules\system\models\users\Groups;
/* @var $this yii\web\View */
/* @var $model app\modules\system\models\users\Users */

$this->title = 'Создать пользователя';
/** Выводим Верхнее меню; */
echo Cabinet::topMenu();
?>

<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('users');?>
        <div class="main-cabinet-content">
            <h2 class="h2 title"><?= Html::encode($this->title) ?></h2>

            <?php $form = ActiveForm::begin(); ?>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <?= $form->field($model, 'name', [
                        'template' => '<div>{label}</div><div>{input}</div><small>Введите имя пользователя</small><div class="text-danger">{error}</div>'
                    ])->textInput(['autofocus' => true]); ?>

                </div>
                <div class="form-group col-md-12">
                    <?= $form->field($model, 'phone', [
                        'template' => '<div>{label}</div><div>{input}</div><small>Введите номер телефона</small><div class="text-danger">{error}</div>'
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


                <?
                foreach( Groups::getAllGroupList() as $val ){
                    echo '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="Users[groups][]" id="switch' . $val['id'] . '" value="' . $val['id'] . '" ><label class="custom-control-label" for="switch' . $val['id'] . '">' . $val['name'] . '</label><br></div>';
                }
                ?>

            </div>


            <div class="form-group">
                <?= Html::submitButton('<i class="fa fa-save"></i> Создать', ['class' => 'btn']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>
