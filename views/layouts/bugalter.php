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
                <span>Bosh sahifa</span>
            </a>
        </li>


        <li>
            <a href="<?=Url::to(['new-goods/'])?>" class=" waves-effect">
                <i class="fas fa-users"></i>
                <span>Yangi maxsulotlar</span>
            </a>
        </li>

        <li>
            <a href="<?=Url::to(['site/admin-sales'])?>" class=" waves-effect">
                <i class="fas fa-users"></i>
                <span>Barcha savdolar</span>
            </a>
        </li>

        <li>
            <a href="<?=Url::to(['product-category/'])?>" class=" waves-effect">
                <i class="fa fa-sitemap"></i>
                <span>Yangi maxsulot turini kiritish</span>
            </a>
        </li>
        <li>
            <a href="<?=Url::to(['site/left-items'])?>" class=" waves-effect">
                <i class="fas fa-users"></i>
                <span>Ombordagi maxsulotlar qoldig'i</span>
            </a>
        </li>

        <li>
            <a href="<?=Url::to(['site/nasiya-return'])?>" class=" waves-effect">
                <i class="fa fa-sitemap"></i>
                <span>Nasiyalar</span>
            </a>
        </li>


    </ul>
</div>