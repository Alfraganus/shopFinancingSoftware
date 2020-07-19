<?php
/**
 * Created by PhpStorm.
 * User: Farhodjon
 * Date: 29.05.2018
 * Time: 23:35
 */

namespace app\assets;


use yii\web\AssetBundle;

class UserAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "assets/lib/css/perfect-scrollbar.min.css",
        "assets/lib/css/material-design-iconic-font.min.css",
        "assets/lib/css/style.css",
        "assets/lib/css/dropify.css",
        'css/site.css',
    ];
    public $js = [
        "assets/lib/js/perfect-scrollbar.jquery.min.js",
        "assets/lib/js/main.js",
        "assets/lib/js/bootstrap.min.js",
        "assets/lib/js/dropify.js",
        "assets/js/main.js",
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}