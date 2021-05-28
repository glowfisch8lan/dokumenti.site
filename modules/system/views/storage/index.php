<?php
use app\modules\system\helpers\Cabinet;

echo Cabinet::topMenu();
?>

<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('files');?>
        <div class="main-cabinet-content">
            <div class="main-cabinet-sites">
                <!--Документы готовые к скачиванию-->
1
                <div class="main-cabinet-sites__item">
                    <div class="main-cabinet-sites__item__head">
                        <b>examplesite.ru</b>
                        <p>Статус: <span class="process">Документы готовятся</span></p>
                    </div>

                    <div class="main-cabinet-sites__item__list">
                        <div class="main-cabinet-sites__item__list__doc">
                            <img src="/img/doc.png" alt="">
                            <p>Документы
                                “О том-то том-то”</p>
                            <a class="not-ready" href="#">Скачать</a>
                        </div>
                        <div class="main-cabinet-sites__item__list__doc">
                            <img src="/img/doc.png" alt="">
                            <p>Документы
                                “О том-то том-то”</p>
                            <a class="not-ready" href="#">Скачать</a>
                        </div>
                        <div class="main-cabinet-sites__item__list__doc">
                            <img src="/img/doc.png" alt="">
                            <p>Документы
                                “О том-то том-то”</p>
                            <a class="not-ready" href="#">Скачать</a>
                        </div>
                        <div class="main-cabinet-sites__item__list__doc">
                            <img src="/img/doc.png" alt="">
                            <p>Документы
                                “О том-то том-то”</p>
                            <a class="not-ready" href="#">Скачать</a>
                        </div>
                        <div class="main-cabinet-sites__item__list__doc">
                            <img src="/img/doc.png" alt="">
                            <p>Документы
                                “О том-то том-то”</p>
                            <a class="not-ready" href="#">Скачать</a>
                        </div>
                    </div>
                </div>

                <!--Документы в обработке-->
                <div class="main-cabinet-sites__item">
                    <div class="main-cabinet-sites__item__head">
                        <b>examplesite.ru</b>
                        <p>Статус: <span class="complete">Документы готовы и доступны для скачивания</span></p>
                    </div>
                    <div class="main-cabinet-sites__item__list">
                        <div class="main-cabinet-sites__item__list__doc">
                            <img src="/img/doc.png" alt="">
                            <p>Документы
                                “О том-то том-то”</p>
                            <a href="#">Скачать</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
