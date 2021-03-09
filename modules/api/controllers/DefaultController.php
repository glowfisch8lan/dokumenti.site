<?php

namespace app\modules\api\controllers;

use yii\web\Controller;

/**
 * Default controller for the `api` module
 */
class DefaultController extends Controller
{
  public function behaviors()
  {
    return [
      'corsFilter' => [
        'class' => 'yii\filters\Cors',
        'cors' => [
          'Origin' => ['*'],
          'Access-Control-Request-Method' => ['POST'],
          'Access-Control-Request-Headers' => ['*'],
        ],
      ],
      'verbs' => [
        'class' => \yii\filters\VerbFilter::className(),
        'actions' => [
          'index' => ['POST'],
        ],
      ],
    ];
  }


  /**
   * Renders the index view for the module
   * @return string
   */
  public function actionIndex()
  {
    return $this->render('index');
  }
}
