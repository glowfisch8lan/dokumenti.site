<?php

namespace app\modules\system;

use Yii;
use app\assets\SitesAsset;
/**
 * system module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\system\controllers';

    /**
     * {@inheritdoc}
     */

    /**
     * @inheritdoc
     */
    public function init()
    {
        SitesAsset::register(Yii::$app->view);
        parent::init();
    }
}
