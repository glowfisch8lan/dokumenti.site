<?php

namespace app\modules\system\controllers;

use Yii;
use yii\web\Controller;
use app\modules\system\models\users\UsersOrders;

/**
 * Default controller for the `system` module
 */
class DefaultController extends Controller
{
    /**
     * Категория "Мои сайты"
     * @return string
     */
    public function actionSites()
    {
        return $this->render('sites');
    }
}
