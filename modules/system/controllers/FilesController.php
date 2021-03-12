<?php

namespace app\modules\system\controllers;

use Yii;
use yii\web\NotFoundHttpException;

class FilesController extends \yii\web\Controller
{
    public function actionGetFile($uuid, $file)
    {
        //$uuid = mb_substr($uuid, 0, mb_strpos($uuid, "."));


//        $uuid = preg_replace("/\.{1,}|\//", "", $uuid);
//        $file = preg_replace("/\//", "", $file);
//        $uuid = mb_substr($uuid, 1, mb_strpos($uuid, "."));
//        $file = mb_substr($file, 0, mb_strpos($file, "."));

        $sendFile = Yii::getAlias('@uploads') . '/files/' . $uuid . '/' . $file;

        if (file_exists(realpath($sendFile)))
            return Yii::$app->response->sendFile($sendFile);
        else
            throw new NotFoundHttpException('Файл не найден...');
    }

}