<?php
use app\modules\system\helpers\Cabinet;
use yii\widgets\ActiveForm;
use app\modules\system\models\settings\Settings;
use app\modules\system\models\users\UsersOrders;
$script = <<< JS
$('.main-cabinet-order__item__radio > input[ type=radio ]').click(function(){
    
    $(document).find('.main-cabinet-order__info').hide();
    $(document).find('#sitetype-'+$(this).attr('id')).fadeIn(600);
    
});  
JS;

$this->registerJs($script, \yii\web\View::POS_READY);

$array = UsersOrders::$data;

echo Cabinet::topMenu();
?>

<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('order');?>
        <div class="main-cabinet-content">

            <?php $form = ActiveForm::begin([
                'options' => [
                    'class' => 'main-cabinet-order',
                    'id' => 'order',
                    'method' => 'post'
                ],
                'fieldConfig' => [
                    'options' => ['class' => 'main-cabinet-order__item'],
                    'template' => "{label}{input}\n<small>{error}</small>"
                ],
            ]); ?>
            <h2 class="h2 title">Разработка документов для вашего сайта в 2 шага</h2>
            <?= $form->field($model, 'url')->textInput(['autofocus' => true])->input('text', ['placeholder' => "Ссылка на Ваш сайт"])->label('<h3 class="h3">Укажите ссылку на ваш сайт</h3>')?>


            <div class="main-cabinet-order__item field-usersorders-url required">
                <h3 class="h3">Выберите категорию сайта</h3>

                <?
                foreach($array as $key => $value)
                {
                    echo '
                <div class="main-cabinet-order__item__radio">
                    <input type="radio" name="UsersOrders[sitetype]" id="'.$value['gid'].'" value="'.$value['id'].'">
                    <label for="'.$value['gid'].'">'.$value['name'].'</label>
                </div>';
                }
                ?>

            </div>
            <?
            foreach($array as $key => $value){
                echo '<div class="main-cabinet-order__info" id="sitetype-'.$value['gid'].'" style="display:none;">
                <div class="main-cabinet-order__info__container">
                    <div class="main-cabinet-order__info__left">
                        <h4 class="h4">'.$value['name'].'</h4>
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
                        <b>'.Settings::getValue($value['settings']).'₽</b>
                        <a href="#" onclick="document.getElementById(\'order\').submit()">Заказать</a>
                    </div>
                </div>
            </div>';
            }
            ?>
            <?php ActiveForm::end();?>

        </div>
    </div>
</section>