<?php

use yii\helpers\Html;
use app\modules\system\helpers\Cabinet;
use yii\widgets\ActiveForm;
use app\modules\system\models\users\Groups;
use app\modules\system\models\users\Users;
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
                    <?= $form->field($model, 'name', [
                        'template' => '<div>{label}</div><div>{input}</div><div class="text-danger">{error}</div>'
                    ])->textInput(['autofocus' => true, 'maxlength' => true, 'disabled' => $model->username == 'admin']); ?>

                </div>
                <div class="form-group col-md-6">
                    <?= $form->field($model, 'username', [
                        'template' => '<div>{label}</div><div>{input}</div><div class="text-danger">{error}</div>'
                    ])->textInput(['maxlength' => true, 'disabled' => $model->username == 'admin']); ?>

                </div>

                <div class="form-group col-md-6">
                    <?= $form
                        ->field($model, 'password', [
                            'template' => '<div>{label}</div><div>{input}</div><small>Введите пароль, если вы хотите его изменить либо оставьте поле пустым.</small>
                            <div class="text-danger">{error}</div>'
                        ])
                        ->passwordInput();
                    ?>
                </div>



            </div>



            <div class="form-group field-users-groups">
                <input type="hidden" name="Users[groups]" value="">
                <div id="users-groups">

                    <?


                    foreach( Groups::getAllGroupList() as $val ){
                        //TODO: Сделать проверку аккаунта на уровне движка;

                        $disabled = ($val['name'] == 'Администраторы' && $model->id == 1) ? 'disabled' : null;
                        $hidden = ($model->id == 1) ? '<input type="hidden" name="Users[groups][]" value="1" />': null;
                        $boolean = ( array_search( $val['name'], array_column( Users::getUserGroups($model->id), 'group') ) === false ) ? null : 'checked';

                        echo $hidden . '<div class="custom-control custom-checkbox">'.'<input type="checkbox" class="custom-control-input" name="Users[groups][]" id="switch' . $val['id'] . '" value="' . $val['id'] . '"' .$boolean .' '.$disabled.'>'.'<label class="custom-control-label" for="switch' . $val['id'] . '">' . $val['name'] . '</label><br>'.'</div>';
                    }
                    ?>

                </div>

                <div class="help-block"></div>
            </div>



            <div class="form-group">
                <?= Html::submitButton('<i class="fa fa-save"></i> Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>
