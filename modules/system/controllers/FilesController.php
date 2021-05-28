<?php

namespace app\modules\system\controllers;

use app\modules\system\models\files\Files;
use Yii;
use yii\web\NotFoundHttpException;
use app\modules\system\models\storage\FilesInfo;

class FilesController extends \yii\web\Controller
{
    public function actionGetFile($uuid, $file)
    {

        $fileOne = Files::findOne(['filename' => $file]);
        $fileInfo = FilesInfo::findOne(['files_id' => $fileOne->id]);

        $sendFile = Yii::getAlias('@uploads') . '/files/' . $uuid . '/' . $file;

        if (file_exists(realpath($sendFile)))
            return Yii::$app->response->sendFile($sendFile, $fileInfo->name);
        else
            throw new NotFoundHttpException('Файл не найден...');
    }

}