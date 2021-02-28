<?php
use app\modules\system\helpers\Cabinet;

echo Cabinet::topMenu();
?>

<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu();?>
        <div class="main-cabinet-content">
            <div class="main-cabinet-orders">
                <h2 class="h2 title">Список заказов</h2>
                <div class="main-cabinet-orders__item">
                    <p class="title">Оплата пакета “Landing-page” для example2.ru</p>
                    <p class="summ">Сумма платежа: <span>3000 ₽</span></p>
                    <p class="status">Статус: <span class="wait">Ожидает оплаты</span></p>
                </div>
                <div class="main-cabinet-orders__item">
                    <p class="title">Пакет “Landing-page” для example2.ru оплачен</p>
                    <p class="summ">Сумма платежа: <span>3000 ₽</span></p>
                    <p class="status">Статус: <span class="success">Оплачено</span></p>
                </div>
                <div class="main-cabinet-orders__item">
                    <p class="title">Оплата example2.ru отменена</p>
                    <p class="summ">Сумма платежа: <span>3000 ₽</span></p>
                    <p class="status">Статус: <span class="canceled">Отменено</span></p>
                </div>
            </div>
        </div>
    </div>
</section>
