<?php
use app\modules\system\helpers\Cabinet;
use yii\helpers\Html;
echo Cabinet::topMenu();
?>

<section class="main-cabinet">
    <div class="main-cabinet-container">
        <?= Cabinet::menu('files');?>
        <div class="main-cabinet-content">
            <h1 class="main-cabinet-sites">

                <? $orders = (new \app\modules\system\models\storage\Files())->getPotentialOrderFiles();

                if(!empty($orders)){
                    foreach($orders as $key => $value)
                {
                    $orderFiles = $value->getOrderFiles();
                    if(!is_array($orderFiles)){
                    echo '<div>
                    <!--Документы в обработке-->
                    <div class="main-cabinet-sites__item">
                        <div class="main-cabinet-sites__item__head">
                            <b>'.$value->url.'</b>
                            <p>Статус: <span class="process">Документы готовятся</span></p>
                        </div>
                        <h1>Документов нет в наличии!</h1>
    
<!--                        <div class="main-cabinet-sites__item__list">
                            <div class="main-cabinet-sites__item__list__doc">
                                <img src="/img/doc.png" alt="">
                                <p>Документы
                                    “О том-то том-то”</p>
                                <a class="not-ready" href="#">Скачать</a>
                            </div>
                        </div>-->
    
                    </div>';
                    }
                    else if(is_array($orderFiles)){
                    ?>
                    <?='<div class="main-cabinet-sites__item">
                        <div class="main-cabinet-sites__item__head">
                            <b>'.$value->url.'</b>
                            <p>Статус: <span class="complete">Документы готовы и доступны для скачивания</span></p>
                        </div><div class="main-cabinet-sites__item__list">'?>
                <?
                    foreach($orderFiles as $filesKey => $files){
                        foreach($files as $fileKey => $file){
                        if(app\modules\system\models\files\Files::fileExist($file->tag, $file->filename)) {
                            $url = '/system/files/get-file?uuid=' . $file->tag . '&file=' . $file->filename;
                        }

                            $val = \app\modules\system\models\storage\FilesInfo::findOne(['files_id' => $file->id])->name;
                            ?>
                       <?='
                            <div class="main-cabinet-sites__item__list__doc">
                                <img src="/img/doc.png" alt="">
                                <p>'.strstr($val, '.', true).'</p>
                                <a href="'.$url.'">Скачать</a>
                            </div>
                        '?>

                    <?}}?>

                    <?='</div></div></div>'?>

                <?}
                }
                } else {
                ?><h2 class="h2 title">В вашем хранилище нет документов!</h2><?
                }
                ?>
            </div>
        </div>
    </div>
</section>
