<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
       // 'css/site.css',
        'css/_all-skins.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        'css/bootstrap.min.css',
        'css/AdminLTE.min.css',
        'css/datepicker3.css',
        //'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
        'css/dropzone.css',
        'css/custom.css',
        'css/bootstrap.min.css.map',
        'css/bootstrap.css.map',
        'css/ionicons/css/ionicons.min.css'
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/app.min.js',
        'js/demo.js',
        'js/bootstrap-datepicker.js',
        'js/jquery.inputmask.js',
        'js/jquery.sparkline.js',
        'js/dropzone.js',
        'js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
