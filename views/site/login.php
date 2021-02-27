<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Login';
?>
<section class="login">
    <form class="login-form" action="">
        <h2 class="h2 title">Вход</h2>
        <div class="login-item">
            <label for="">E-mail <span>*</span></label>
            <input type="text" name="e-mail" id="e-mail" placeholder="example@mail.ru">
        </div>
        <div class="login-item">
            <label for="">Пароль <span>*</span></label>
            <input type="text" name="password" id="password" placeholder="**********">
        </div>
        <button type="submit">Войти</button>
    </form>
    <div class="reg-already">
        <p>Еще не зарегистрировались? &nbsp; <a href="reg.html">Регистрация</a></p>
    </div>
</section>