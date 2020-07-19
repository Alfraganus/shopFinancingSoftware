<?php
use yii\helpers\Url;
?>
<div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title">Menu</li>

        <li>
            <a href="<?=\yii\helpers\Url::to(['/'])?>" class="waves-effect">
                <i class="ri-dashboard-line"></i>
                <span>Yangi maxsulotlar</span>
            </a>
        </li>
        <li>
            <a href="<?=\yii\helpers\Url::to(['site/left-items'])?>" class="waves-effect">
                <i class="ri-dashboard-line"></i>
                <span>Ombordagi maxsulotlar</span>
            </a>
        </li>

        <li>
            <a href="<?=\yii\helpers\Url::to(['site/warehouse-check-product'])?>" class="waves-effect">
                <i class="ri-dashboard-line"></i>
                <span>Yakunlangan xaridlar</span>
            </a>
        </li>


    </ul>
</div>