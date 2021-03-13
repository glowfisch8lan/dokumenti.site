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
class InputMaskedAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/system/assets';
    public $js = [
        'js/jquery.maskedinput.min.js'
    ];
    public $depends = [
    ];
}
