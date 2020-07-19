<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?=Yii::$app->homeUrl?>images/favicon.ico">
    <?php $this->registerCsrfMetaTags(); ?>
    <title><?= Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
</head>
<?php $user = Yii::$app->user->identity; ?>
<body data-sidebar="dark">
<?php $this->beginBody(); ?>



<!-- Begin page -->
<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <!--<div class="navbar-brand-box">
                    <a href="<?/*= $app->homeUrl; */?>" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?/*=Yii::$app->homeUrl*/?>images/logo-sm-dark.png" alt="" height="30">
                    </span>
                        <span class="logo-lg">
                        <img src="<?/*=Yii::$app->homeUrl*/?>images/logo-dark.png" alt="" height="35">
                    </span>
                    </a>

                    <a href="<?/*= $app->homeUrl; */?>" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?/*=Yii::$app->homeUrl*/?>images/logo-sm-dark.png" alt="" height="30">
                    </span>
                        <span class="logo-lg">
                        <img src="<?/*=Yii::$app->homeUrl*/?>images/logo-dark.png" alt="" height="35">
                    </span>
                    </a>
                </div>
-->
                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                    <i id="vermenu" class="ri-menu-2-line align-middle"></i>
                </button>

                <!-- App Search-->
            </div>

            <div class="d-flex">


                <div class="dropdown d-inline-block user-dropdown">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="<?=Yii::$app->homeUrl?>images/users/avatar-2.jpg" alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ml-1"><?=Yii::$app->user->identity->fullname?></span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="<?= Url::to(['site/logout'])?>" data-method="post">
                            <i class="ri-shut-down-line align-middle mr-1 text-danger"></i> Tizimdan chiqish
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- Left Sidebar Start -->
    <div class="vertical-menu">
        <div data-simplebar class="h-100">

            <!--- Sidemenu -->
            <?php
            switch ($user->role) {
                case 1: /*admin role*/
                   echo $this->render('admin');
                    break;
                case 2:  /*sotuvchi role*/
                   echo $this->render('sotuvchi');
                    break;
                case 3: /*omborchi role*/
                   echo $this->render('omborchi');
                    break;
                case 4: /*bugalter role*/
                   echo $this->render('bugalter');
                    break;
                case 5: /*kassir role*/
                   echo $this->render('kassir');
                    break;
            }
            ?>

            <!-- Sidebar -->

        </div>
    </div>
    <!-- Left Sidebar End -->

    <!-- Start right Content here -->
    <div class="main-content">
        <div class="page-content">

            <div class="card p-3">
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">

            </div>
        </footer>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title px-3 py-4">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
            <h5 class="m-0">Settings</h5>
        </div>

        <!-- Settings -->
        <hr class="mt-0" />
        <h6 class="text-center mb-0">Choose Layouts</h6>

        <div class="p-4">
            <div class="mb-2">
                <img src="<?=Yii::$app->homeUrl?>images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="">
            </div>
            <div class="custom-control custom-switch mb-3">
                <input type="checkbox" class="custom-control-input theme-choice" id="light-mode-switch" checked />
                <label class="custom-control-label" for="light-mode-switch">Light Mode</label>
            </div>

            <div class="mb-2">
                <img src="<?=Yii::$app->homeUrl?>images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="">
            </div>
            <div class="custom-control custom-switch mb-3">
                <input type="checkbox" class="custom-control-input theme-choice" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css" />
                <label class="custom-control-label" for="dark-mode-switch">Dark Mode</label>
            </div>

            <div class="mb-2">
                <img src="<?=Yii::$app->homeUrl?>images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="">
            </div>
            <div class="custom-control custom-switch mb-5">
                <input type="checkbox" class="custom-control-input theme-choice" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css" />
                <label class="custom-control-label" for="rtl-mode-switch">RTL Mode</label>
            </div>
        </div>

    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->
<?=$this->registerJsFile(Yii::$app->request->BaseUrl . 'dist/js/appp.js', ['position' => $this::POS_HEAD]);?>
<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<style>
    .help-block {
        color:red;
    }
    .select2-container, .select2-selection--single, .select2-selection__rendered {
        line-height: 12px !important;
    }
    .select2-selection__arrow {
        height: 26px !important;
    }
    option {
        font-size: 20px !important;
    }
    .select2-hidden-accessible {
        font-size: 20px !important;
    }
    .select2-results__option {
        font-size: 24px !important;
    }

</style>


<?php $this->endBody(); ?>

</body>

</html>
<?php $this->endPage(); ?>