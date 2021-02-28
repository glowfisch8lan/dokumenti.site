<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
$js = <<< JS

$('.main-carousel').owlCarousel({
            items: 1,
            nav: true
        });

JS;

$this->registerJs( $js, $position = yii\web\View::POS_END, $key = null );
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="wrapper">
    <div class="callback">
        <div class="callback-container">
            <form class="callback-content">
                <a class="close" href="#">
                    <img src="/img/close.png" alt="">
                </a>
                <h2 class="h2 title">
                    Оставьте нам свой номер и <br>
                    мы обязательно перезвоним
                </h2>
                <div class="callback-content__item">
                    <label for="name">Ваше имя</label>
                    <input type="text" name="name" id="name" placeholder="Иван">
                </div>
                <div class="callback-content__item">
                    <label for="phone">Ваш телефон</label>
                    <input type="text" name="phone" id="phone" placeholder="+7 900 000 00 00">
                </div>
                <div class="callback-content__item">
                    <input type="checkbox" name="polit" id="polit">
                    <label for="polit">Я согласен на обработку персональных данных</label>
                </div>
                <button type="submit">Отправить</button>
            </form>
        </div>
    </div>

    <div class="mobile-menu">
        <a href="#" class="close">
            <svg version="1.1" id="Capa_1" width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve">
                        <path d="M284.286,256.002L506.143,34.144c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L256,227.717
                            L34.143,5.859c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.475,0,28.285l221.857,221.857L5.858,477.859
                            c-7.811,7.811-7.811,20.475,0,28.285c3.905,3.905,9.024,5.857,14.143,5.857c5.119,0,10.237-1.952,14.143-5.857L256,284.287
                            l221.857,221.857c3.905,3.905,9.024,5.857,14.143,5.857s10.237-1.952,14.143-5.857c7.811-7.811,7.811-20.475,0-28.285
                            L284.286,256.002z"/>
                </svg>
        </a>
        <div class="mobile-container">
            <div class="mobile-menu-logo">
                <a href="/">
                    <img src="/img/logo_white.png" alt="">
                </a>
            </div>
            <div class="mobile-menu-links">
                <a href="/">Главная</a>
                <a href="/#services">Документы и цены</a>
                <a href="/#articles">Требования закона РФ</a>
                <a href="/#arbitrage-practice">Судебные практики</a>
                <a href="/#checking">Проверка сайта</a>
            </div>
            <div class="mobile-menu-callback">
                <a href="#">Обратная связь</a>
            </div>
            <div class="mobile-menu-phone">
                <a href="telTo:+7(499)9388764">
                    <img src="/img/open-24-hours-mobile.svg" alt="">
                    <p>+7 (499) 938-87-64 <br>
                        <span>Круглосуточная поддержка</span>
                    </p>
                </a>
                <a href="mailTo:example@mail.ru">
                    <img src="/img/mail-mobile.svg" alt="">
                    <p>
                        example@mail.ru
                    </p>
                </a>
            </div>
        </div>
        <div class="mobile-menu-login">
            <a href="/site/login">Войти</a>
            <a href="/site/sign-up">Зарегистрироваться</a>
        </div>
    </div>

    <header class="header">
        <div class="header-container">
            <div class="header-logo">
                <a href="/">
                    <img src="/img/logo_dark.png" alt="">
                </a>
            </div>
            <div class="header-callback">
                <a href="#">Обратная связь</a>
            </div>
            <div class="header-phone">
                <a href="telTo:+7(499)9388764">
                    <img src="/img/open-24-hours.svg" alt="">
                    <p>+7 (499) 938-87-64 <br>
                        <span>Круглосуточная поддержка</span>
                    </p>
                </a>
            </div>
        </div>
    </header>

    <header class="header-nav">
        <div class="header-nav-container">
            <div class="header-nav-links">
                <a href="/">Главная</a>
                <a href="/#services">Документы и цены</a>
                <a href="/#articles">Требования закона РФ</a>
                <a href="/#arbitrage-practice">Судебные практики</a>
                <a href="/#checking">Проверка сайта</a>
            </div>
            <div class="header-nav-login">
                <?echo (!Yii::$app->user->isGuest) ? '<a href="/system/default/orders">'.Yii::$app->user->identity->username.'</a><span>|</span><a href="/site/logout" data-method="post">Выход</a>' : '<a href="/site/login">Войти</a><span>|</span><a href="/site/sign-up">Зарегистрироваться</a>';?>
            </div>
            <a href="#" class="hamb">
                <svg height="32px" viewBox="0 -53 384 384" width="32px" xmlns="http://www.w3.org/2000/svg"><path d="m368 154.667969h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/><path d="m368 32h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/><path d="m368 277.332031h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/></svg>
            </a>
        </div>
    </header>
    <?= $content ?>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <a href="/">
                    <img src="/img/logo.png" alt="">
                </a>
            </div>
            <div class="footer-navs">
                <div class="footer-navs-item">
                    <b>Навигация</b>
                    <a href="/">Главная</a>
                    <a href="/#">Услуги и цены</a>
                    <a href="/#">О нас</a>
                    <a href="/#">Этапы работы</a>
                </div>
                <div class="footer-navs-item">
                    <b>Доп. информация</b>
                    <a href="/#">Законы РФ</a>
                    <a href="/#">Проверка сайта</a>
                </div>
                <div class="footer-navs-item">
                    <b>Личный кабинет</b>

                    <a href="/site/login">Вход</a>
                    <a href="/site/sign-up">Регистрация</a>
                </div>
            </div>
            <div class="footer-callback">
                <a class="callback-button" href="#">Обратная связь</a>
                <div class="footer-phone">
                    <a href="telTo:+7(499)9388764">
                        <img src="/img/open-24-hours.svg" alt="">
                        <p>+7 (499) 938-87-64 <br>
                            <span>Круглосуточная поддержка</span>
                        </p>
                    </a>
                    <a class="mail" href="mailTo:info@dokumenti.site">info@dokumenti.site</a>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>Copyright 2021 ©. Все права защищены.</p>
            <a href="#">Политика конфиденциальности</a>
            <a href="#">Оферта</a>
        </div>
    </footer>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
