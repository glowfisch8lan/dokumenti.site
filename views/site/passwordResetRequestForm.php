<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Запрос на сброс пароля';

?>
<section class="content login">

  <div class="container">
    <h2 class="content__h3"><?= Html::encode($this->title) ?></h2>
    <p>Введите электронный адрес <br>для получения информации о сбросе пароля.</p>

    <?php $form = ActiveForm::begin([
      'id' => 'request-password-reset-form', 'options' => [
      'class' => 'login__form'
    ]]); ?>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label(false) ?>
      <?= Html::submitButton('Отправить', ['class' => 'btn btn_profile']) ?>
    <?php ActiveForm::end(); ?>
  </div>
</section>
