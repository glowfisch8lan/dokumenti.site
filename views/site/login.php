<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Вход';
?>
<section class="login">

<?php $form = ActiveForm::begin([
    'options' => [
                'class' => 'login-form'
             ],
    'fieldConfig' => [
        'options' => ['class' => 'login-item'],
        'template' => "{label}\n{input}\n<div>{error}</div>"
    ],
]); ?>
    <h2 class="h2 title">Вход</h2>
<?= $form->field($model, 'username')->textInput(['autofocus' => true])->input('login', ['placeholder' => "example@mail.ru", 'id' => 'e-mail'])->label('E-mail <span>*</span>')?>
<?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => "Введите свой пароль",  'id' => 'password'])->label('Пароль <span>*</span>')?>

<div class="form-group">
    <?= Html::submitButton('Вход', ['class' => 'btn btn-primary shadow- mb-4', 'name' => 'login-button'])?>
</div>

<?php ActiveForm::end();?>
</section>