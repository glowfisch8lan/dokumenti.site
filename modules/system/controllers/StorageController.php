<?php

namespace app\modules\system\controllers;

use Yii;
use yii\web\Controller;

/**
 * Storage controller for the `system` module
 */
class StorageController extends Controller
{
    /**
     * Категория "Мои файлы"
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
