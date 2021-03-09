<?php


namespace app\modules\api\controllers;


use phpDocumentor\Reflection\Types\Integer;
use Yii;
use yii\rest\Controller;
use yii\web\Response;

class UserController extends Controller
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
          'check-user-balance' => ['POST'],
        ],
      ],
    ];
  }

  public function beforeAction($action)
  {
    Yii::$app->response->format = Response::FORMAT_JSON;

    return parent::beforeAction($action);
  }



  public function actionCheckUserBalance()
  {
    $orderSum = \Yii::$app->request->post('orderSum');

    $balance = \Yii::$app->user->identity->balance;

    if ($balance < (int)$orderSum) {
      \Yii::$app->response->data = [
        'result' => 0,
        'message' => 'Недостаточно средств на счёте'
      ];
    } else {
      \Yii::$app->response->data = [
        'result' => 1,
        'message' => 'Средств достаточно'
      ];
    }


  }

}