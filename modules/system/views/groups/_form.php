<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \app\modules\system\models\interfaces\modules\Modules;

$js = <<< JS

    $("div.module-title").each(function() {
        var elements = $(this).closest('dl').find('div.module-items > input:checkbox.custom-control-input');
        $(this).find('input:checkbox').is(':checked') ? elements.prop('disabled', false) : elements.prop('disabled', true);
     });

    $('.module-toggle').on('click', function () {
        if($(this).find('i').hasClass('show'))
            {
                $(this).find('i').removeClass('fa-arrow-circle-down').addClass('fa-arrow-circle-left').addClass('hide').removeClass('show');
            }
        else{
            $(this).find('i').removeClass('fa-arrow-circle-left').addClass('fa-arrow-circle-down').addClass('show').removeClass('hide');
        }
        
        
        $(this).closest('dl').find('.module-items').fadeToggle( "fast" );
    });
    
    // $('.checkbox-toggle').on('click', function () {
    //         var that = this;
    //        
    //
    //         status = (!$(this).hasClass('checked') && $(this).hasClass('unchecked') && !$(this).hasClass('unknown')) ? (
    //              function(obj) {
    //                  $(this).removeClass('unchecked').addClass('unknown').find('i.fa').removeClass('fa-square-o').addClass('fa-square');
    //                  return 0;
    //              }).bind(that)() : false;
    //         if(status == '0'){return;}
    //        
    //         status = ($(this).hasClass('checked') && !$(this).hasClass('unchecked') && !$(this).hasClass('unknown')) ? (
    //              function(obj) {
    //                  $(this).removeClass('checked').addClass('unchecked').find('i.fa').removeClass('fa-check-square').addClass('fa-square-o');
    //                  $(this).closest('dl').find('div.module-items > input:checkbox').prop('checked', false);
    //                  return 0;
    //              }).bind(that)() : false;
    //        
    //         status = (!$(this).hasClass('checked') && !$(this).hasClass('unchecked') && $(this).hasClass('unknown')) ? (
    //             function(obj) {
    //                 $(this).removeClass('unknown').addClass('checked').find('i.fa').removeClass('fa-square').addClass('fa-check-square-o');
    //                 $(this).closest('dl').find('div.module-items > input:checkbox').prop('checked', true);
    //                 return 0;
    //             }).bind(that)() : false;
    // }); 
     $('div.module-title > input:checkbox').on('click', function () {
        $(this).is(':checked') ? $(this).closest('dl').find('div.module-items > input:checkbox.custom-control-input').prop('disabled', false) : $(this).closest('dl').find('div.module-items > input:checkbox.custom-control-input').prop('disabled', true);
    });

JS;

$this->registerJs( $js, $position = yii\web\View::POS_END, $key = null );

?>
<?php $form = ActiveForm::begin(); ?>

<div class="form-row row">
    <div class="form-group col-md-12">
        <?= $form->field($model, 'name', [
            'template' => '<div>{label}</div><div>{input}</div><small>Введите имя новой Группы</small>
            <div class="text-danger small">{error}</div>'
        ])->textInput(['autofocus' => true]); ?>
    </div>

    <div class="form-group col-md-12">
        <?= $form->field($model, 'description', [
            'template' => '<div>{label}</div><div>{input}</div><small>Введите описание Группы</small>
            <div class="text-danger small">{error}</div>'
        ]); ?>

    </div>

    <div class="form-group field-users-groups">
        <input type="hidden" name="Groups[permissions]" value="">
        <div id="users-groups">
            <?

            /**
             * Формируем список разрешений;
             */
            $index = 0;
            foreach(Modules::getAllModules() as $module ){
                $label = null;
                /**
                 * Создаем группу Модуль
                 */
                $titleStatus = (!empty($model->usedPermissions) && (in_array($module->visible, $model->usedPermissions))) ? 'checked' : null;

                /**
                 * Наполняем Модуль разрешениями
                 */
                foreach($module->routes as $route){
                    $boolean = (!empty($model->usedPermissions) && (in_array($route['access'], $model->usedPermissions))) ? 'checked' : null;

                    $label .= '<dd><div class="custom-control custom-checkbox module-items" style="display: none;"><input type="checkbox" class="custom-control-input" name="Groups[permissions][]" id="switch' . $index . '" value="' . $route['access'] . '"' .$boolean .'><label class="custom-control-label" for="switch' . $index . '">' . $route['description'] . '</label></div></dd>';
                    $index++;
                }

                /**
                 * Выводим сформированный модуль;
                 * <a href="#" class="checkbox-toggle unknown"><i class="fas fa-square" aria-hidden="true"></i></a>
                 */
                echo '<dl><dd><div class="custom-control custom-checkbox module-title"><input type="checkbox" class="custom-control-input" name="Groups[permissions][]" id="switch' . $index . '" value="' . $module->visible . '"' .$titleStatus .'><label class="custom-control-label" for="switch' . $index . '"><strong>' . $module->name . ' (Доступ к модулю)</strong></label>&nbsp;<a href="#" class="module-toggle"><i class="fas fa-arrow-circle-left hide" aria-hidden="true"></i></a>&nbsp;</div></dd>' . $label . '</dl>';
                $index++;
            }
            ?>

        </div>

        <div class="help-block"></div>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('<i class="fa fa-save"></i> Сохранить', ['class' => 'btn']) ?>
</div>

<?php ActiveForm::end(); ?>
