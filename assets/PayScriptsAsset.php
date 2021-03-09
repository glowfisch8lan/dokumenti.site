<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap javascript files.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 */
class PayScriptsAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/system/assets/';
    public $css = [
    ];
    public $js = [
        'js/refill.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
