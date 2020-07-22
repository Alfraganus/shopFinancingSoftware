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
            <a href="<?=Url::to(['user/'])?>" class=" waves-effect">
                <i class="fas fa-users"></i>
                <span>Yangi foydalanuvchi qo'shish</span>
            </a>
        </li>

        <li>
            <a href="<?=Url::to(['site/admin-sales'])?>" class=" waves-effect">
                <i class="fas fa-users"></i>
                <span>Savdolar</span>
            </a>
        </li>

        <li>
            <a href="<?=Url::to(['site/left-items'])?>" class=" waves-effect">
                <i class="fas fa-users"></i>
                <span>Ombordagi maxsulotlar qoldig'i</span>
            </a>
        </li>

        <li>
            <a href="<?=Url::to(['site/admin-payments'])?>" class=" waves-effect">
                <i class="fas fa-users"></i>
                <span>To'lovlar</span>
            </a>
        </li>

        <li>
            <a href="<?=Url::to(['site/admin-nasiya'])?>" class=" waves-effect">
                <i class="fas fa-users"></i>
                <span>Nasiya savolar</span>
            </a>
        </li>

    </ul>
</div>