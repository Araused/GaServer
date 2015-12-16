<?php

namespace app\assets;

use yii\web\AssetBundle;

class Ie8Asset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/excanvas.js',
    ];
    public $jsOptions = [
        'condition' => 'lte IE 8',
    ];

}
