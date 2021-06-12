<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
use yii\bootstrap4\Alert;
use yii\widgets\ActiveForm;
use app\modules\feedback\models\FeedbackRequest;
use app\modules\system\models\users\Groups;
use app\modules\system\models\users\Users;
use app\modules\system\models\history\History;
use yii\widgets\Pjax;
AppAsset::register($this);
$js = <<< JS
$('button.close').on('click', function(){
   $('.box-alert').hide();
});
$('.main-carousel').owlCarousel({
            items: 1,
            nav: true
        });

JS;
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::to(['/favicon.ico'])]);
$this->registerJs( $js, $position = yii\web\View::POS_END, $key = null );
$model = new FeedbackRequest();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="6026d9741acd055e" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        .box-alert {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .box-alert div {
            margin:1vh 0 0 0;
            width:50vw;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<div class="preloader">
    <div class="preloader__row">
        <div class="preloader__item"></div>
        <div class="preloader__item"></div>
    </div>
</div>
<div id="wrapper">
    <div class="callback">
        <div class="callback-container">
            <?php $form = ActiveForm::begin([
                    'action' => '/site/callback-to',
                'options' => [
                    'class' => 'callback-content'
                ],
                'fieldConfig' => [
                    'options' => ['class' => 'callback-content__item'],
                    'template' => "{label}\n{input}\n{error}"
                ],
            ]); ?>
            <a class="close" href="#">
                <img src="/img/close.png" alt="">
            </a>
            <h2 class="h2 title">
                Оставьте нам свой номер и <br>
                мы обязательно перезвоним
            </h2>
            <?= $form->field($model, 'name')->textInput(['autofocus' => true])->input('text', ['placeholder' => "Ваше Имя",'id' => 'name'])->label('Ваше имя',['for' => 'name'])?>
            <?= $form->field($model, 'phone')->textInput(['autofocus' => true])->input('text', ['placeholder' => "+7 900 000 00 00", 'id' => 'phone', 'class' => 'phone'])->label('Телефон')?>

            <?=$form->field($model, 'polit',['template' => '{input}{label}{error}{hint}'])
                ->input('checkbox')->label('Я согласен на обработку персональных данных');?>

            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => '', 'name' => 'login-button'])?>
            </div>

            <?php ActiveForm::end();?>
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
                <a href="telTo:+7(495)1381488">
                    <img src="/img/open-24-hours-mobile.svg" alt="">
                    <p>+7 (495) 138-14-88 <br>
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
            <?php  if(Yii::$app->user->isGuest)
            {
                echo '<a href="/site/login">Войти</a><a href="/site/sign-up">Зарегистрироваться</a>';
            }
            else {
                echo Html::a( 'Заказать', '/system/orders/create');
                echo Html::a( 'Личный кабинет', '/system/orders');
            }
            ?>

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
                <a href="telTo:+7(495)1381488">
                    <img src="/img/open-24-hours.svg" alt="">
                    <p>+7 (495) 138-14-88 <br>
                        <span>Круглосуточная поддержка</span>
                    </p>
                </a>
            </div>
        </div>
    </header>

    <header class="header-nav">
        <div class="header-nav-container">
            <div class="header-nav-links">
                <a href="/"><i class="fas fa-home"></i>&nbsp;Главная</a>
                <a href="/#services">Документы и цены</a>
                <a href="/#articles">Требования закона РФ</a>
                <a href="/#arbitrage-practice">Судебные практики</a>
                <a href="/#checking">Проверка сайта</a>
            </div>
            <div class="header-nav-login">
                <?
                if(!Yii::$app->user->isGuest) $link = '/system/orders';

                echo (!Yii::$app->user->isGuest) ? '<a href="'.$link.'"><i class="fa fa-user"></i>&nbsp;'.Yii::$app->user->identity->username.'</a><span>|</span><a href="/site/logout" data-method="post"><i class="fas fa-sign-out-alt"></i>&nbsp;Выход</a>' : '<a href="/site/login">Войти</a><span>|</span><a href="/site/sign-up">Зарегистрироваться</a>';?>
                
            </div>
            <a href="#" class="hamb">
                <svg height="32px" viewBox="0 -53 384 384" width="32px" xmlns="http://www.w3.org/2000/svg"><path d="m368 154.667969h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/><path d="m368 32h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/><path d="m368 277.332031h-352c-8.832031 0-16-7.167969-16-16s7.167969-16 16-16h352c8.832031 0 16 7.167969 16 16s-7.167969 16-16 16zm0 0"/></svg>
            </a>
        </div>
    </header>
    <?= $content ?>
    <!--Добавить условие при котором модальное окно появляется только когда пользователль зарегистрирован -->
    <div class="modal fade profile__modal" id="refill-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-narrow modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Пополнение</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <?php $model = new History() ?>

                    <?php $form = ActiveForm::begin([
                            'action' => '/api/balance/increase',
                            'options' => ['class' => 'profile__refill-form']
                    ]) ?>

                    <?= $form->field($model, 'amount', [
                        'labelOptions' => ['class' => 'profile__refill-label']
                    ])->textInput([
                        'class' => 'form-control profile__order-url',
                        'placeholder' => '3000'
                    ])->label('Введите сумму') ?>

                    <? echo $form->field($model, 'paymentType', [
                        'labelOptions' => ['class' => 'profile__refill-label'],
                        'template' => '{label}<div class="profile__select">{input}</div> <div class="help-block">{error}</div>'
                    ])->dropDownList(
                        [
                        \app\modules\system\models\users\UsersOrders::PAYMENT_TYPE_CARD => 'Карта Visa, Mastercard, МИР',
                            \app\modules\system\models\users\UsersOrders::PAYMENT_TYPE_INVOICE => 'Счёт юридического лица'
                        ],
                        [
                            'class' => 'form-control profile__order-url profile__order-select'
                        ]
                    )->label('Способ оплаты');?>

                    <div class="form-group">
                        <?= Html::submitButton('Оплатить', ['class' => 'btn btn_prices pay-refill', 'name' => 'login-button'])?>
                    </div>

                    <?php ActiveForm::end() ?>


                </div>
            </div>
        </div>
    </div>

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
                    <a href="/#services">Услуги и цены</a>
                    <a href="/#about">О нас</a>
                    <a href="/#steps">Этапы работы</a>
                </div>
                <div class="footer-navs-item">
                    <b>Доп. информация</b>
                    <a href="/#laws">Законы РФ</a>
                    <a href="/#check">Проверка сайта</a>
                </div>
                <div class="footer-navs-item">
                    <b>Личный кабинет</b>
                    <?php  if(Yii::$app->user->isGuest)
                    {
                        echo '<a href="/site/login">Вход</a><a href="/site/sign-up">Регистрация</a>';
                    }
                    else {
                        echo Html::a( Yii::$app->user->identity->username, '/system/orders');
                    }
                    ?>

                </div>
            </div>


            <div class="footer-callback">
                <a class="callback-button" href="#">Обратная связь</a>
                <div class="footer-phone">
                    <a href="telTo:<?= Yii::$app->params['callbackPhone'] ?>">
                        <img src="/img/open-24-hours.svg" alt="">
                        <p><?= Yii::$app->params['callbackPhone'] ?><br>
                            <span>Круглосуточная поддержка</span>
                        </p>
                    </a>
                    <a href="mailto:<?= Yii::$app->params['adminEmail'] ?>" class="header__email footer__email">
                        <?= Yii::$app->params['adminEmail'] ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>Copyright 2021 ©. Все права защищены.</p>
            <a href="#">Политика конфиденциальности</a>
            <a href="/uploads/dokumenti_site_oferta.pdf" target="_blank">Оферта</a>
            <a href="https://webrazavr.ru/">WEBRAZAVR - Студия для Вашего бизнеса</a>
        </div>
    </footer>
</div>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
