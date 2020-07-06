<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NewGoods */

$this->title = 'Taxrirlash: ';
$this->params['breadcrumbs'][] = ['label' => 'New Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'maxsulot taxriri', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="new-goods-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'productPrices' => $productPrices,
    ]) ?>

</div>
