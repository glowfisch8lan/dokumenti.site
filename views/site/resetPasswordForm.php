<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Сброс пароля';

?>

<section class="content login">

  <div class="container">
    <h2 class="content__h3"><?= Html::encode($this->title) ?></h2>
    <p>Введите новый пароль:</p>

    <?php $form = ActiveForm::begin([
      'id' => 'reset-password-form', 'options' => [
        'class' => 'login__form'
      ]]); ?>
    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true])->label(false)  ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn_profile']) ?>
    <?php ActiveForm::end(); ?>
  </div>
</section>