<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NewGoods */

$this->title = 'Create New Goods';
$this->params['breadcrumbs'][] = ['label' => 'New Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-goods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
