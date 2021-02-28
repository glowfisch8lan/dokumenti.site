<?php
use app\modules\system\helpers\Cabinet;

echo Cabinet::topMenu();
?>

<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu();?>
        <div class="main-cabinet-content">
            <form class="main-cabinet-order">
                <h2 class="h2 title">Разработка документов для вашего сайта в 2 шага</h2>
                <div class="main-cabinet-order__item">
                    <h3 class="h3">Укажите ссылку на ваш сайт</h3>
                    <input type="text" name="" id="" placeholder="Ссылка на Ваш сайт">
                </div>
                <div class="main-cabinet-order__item">
                    <h3 class="h3">Выберите категорию сайта</h3>

                    <div class="main-cabinet-order__item__radio">
                        <input type="radio" name="site-type" id="landing">
                        <label for="landing">Landing page</label>
                    </div>

                    <div class="main-cabinet-order__item__radio">
                        <input type="radio" name="site-type" id="visitka">
                        <label for="visitka">Сайт-визитка</label>
                    </div>

                    <div class="main-cabinet-order__item__radio">
                        <input type="radio" name="site-type" id="shop">
                        <label for="shop">Интернет-магазин</label>
                    </div>

                    <div class="main-cabinet-order__item__radio">
                        <input type="radio" name="site-type" id="forum">
                        <label for="forum">Форум</label>
                    </div>
                </div>
                <div class="main-cabinet-order__info">
                    <div class="main-cabinet-order__info__container">
                        <div class="main-cabinet-order__info__left">
                            <h4 class="h4">Landing-page</h4>
                            <p>Не следует, однако забывать, что постоянное информационно пропагандистское</p>
                        </div>
                        <div class="main-cabinet-order__info__center">
                            <ul>
                                <li><span>Повседневная практика показывает, </span></li>
                                <li><span>что Консультация с широким активом </span></li>
                                <li><span>представляет Собой интересный </span></li>
                                <li><span>эксперимент проверки систем </span></li>
                                <li><span>Массового участия. Товарищи! </span></li>
                            </ul>
                        </div>
                        <div class="main-cabinet-order__info__right">
                            <b>3 000 ₽</b>
                            <a href="#">Оплатить</a>
                        </div>
                    </div>
                </div>
                <div class="main-cabinet-order__dontknow">
                    <h3 class="h3">Не знаете какой у Вас сайт? <br>
                        <span>Бесплатная оценка для Вас</span></h3>
                    <p>Наш специалисты оценят Ваш сайт и подберут документы и тд., что постоянное информационно-пропагандистское обеспечение нашей деятельности в значительной степени обуславливает создание модели развития.</p>
                    <a href="#">Заказать</a>
                </div>
            </form>
        </div>
    </div>
</section>