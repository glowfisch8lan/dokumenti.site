<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
//    public $publishOptions = [
//        'forceCopy' => true
//    ];
    public $js = [
        'js/jquery.touch.js',
        'js/common.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',

        'yii\bootstrap4\BootstrapPluginAsset',
        'app\assets\PreloaderAsset',

        'app\assets\MainAsset',
        'app\assets\HeaderFootersAsset',
        'app\assets\LoginRegAsset',
        'app\assets\SitesAsset',

        'app\assets\OwlCarouselAsset',
        'app\assets\FontAwesomeAsset',

        'app\assets\PayScriptsAsset'

    ];
}
