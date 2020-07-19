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
    public $css = [
        'dist/css/app.min.css',
        'dist/libs/select2/css/select2.min.css',
        'dist/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css',
        'dist/libs/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css',
        'dist/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css',
        'dist/css/bootstrap.min.css',
        'dist/css/icons.min.css',
        'dist/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css',
        'dist/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
        'dist/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css',
        'dist/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css',
        "dist/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css",
        "dist/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css",
        "dist/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" ,
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css',

    ];
    public $js = [
        'dist/libs/bootstrap/js/bootstrap.bundle.min.js',
        'dist/libs/metismenu/metisMenu.min.js',
        'dist/libs/simplebar/simplebar.min.js',
        'dist/libs/node-waves/waves.min.js',
        'dist/libs/select2/js/select2.min.js',
        'dist/libs/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js',
        'dist/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
        'dist/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js',
        'dist/libs/bootstrap-maxlength/bootstrap-maxlength.min.js',
        'dist/js/pages/form-advanced.init.js',
        'dist/libs/apexcharts/apexcharts.min.js',
        'dist/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js',
        'dist/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js',
        'dist/libs/datatables.net/js/jquery.dataTables.min.js',
        'dist/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
        'dist/libs/datatables.net-responsive/js/dataTables.responsive.min.js',
        'dist/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js',
        'dist/js/pages/dashboard.init.js',
        'dist/js/app.js',

       "dist/libs/datatables.net-buttons/js/dataTables.buttons.min.js",
        "dist/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js",
        "dist/libs/jszip/jszip.min.js",
        "dist/libs/pdfmake/build/pdfmake.min.js",
        "dist/libs/pdfmake/build/vfs_fonts.js",
        "dist/libs/datatables.net-buttons/js/buttons.html5.min.js",
        "dist/libs/datatables.net-buttons/js/buttons.print.min.js",
        "dist/libs/datatables.net-buttons/js/buttons.colVis.min.js",
        "dist/libs/datatables.net-keytable/js/dataTables.keyTable.min.js",
        "dist/libs/datatables.net-select/js/dataTables.select.min.js",
        "https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js",
        'dist/js/appp.js',
        'dist/js/charts.js',
    ];


    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
    public function init()
    {
        parent::init();
        $this->js[] = 'dist/js/appp.js';
    }
  /*  public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );*/
}
