<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/font-awesome/css/font-awesome.min.css',
        'css/site.css',
    ];
    public $js = [
        'js/flot-master/jquery.flot.js',
        'js/flot-master/jquery.flot.time.js',
        'js/flot-master/jquery.flot.navigate.js',
        'js/flot-master/jquery.flot.crosshair.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
