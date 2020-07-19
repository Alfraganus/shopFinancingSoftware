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
            <a href="<?=Url::to(['product-category/'])?>" class=" waves-effect">
                <i class="fa fa-sitemap"></i>
                <span>Yangi maxsulot turini kiritish</span>
            </a>
        </li>

    </ul>
</div>