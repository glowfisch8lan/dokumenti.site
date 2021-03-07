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

        if (file_exists(Yii::getAlias(Yii::getAlias('@uploads') . '/files/' . $uuid . '/' . $file)))
            return Yii::$app->response->sendFile(Yii::getAlias('@uploads') . '/files/' . $uuid . '/' . $file);
        else
            throw new NotFoundHttpException();
    }

}