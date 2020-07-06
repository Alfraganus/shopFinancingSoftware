<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searchModel\NewGoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Barcha maxsulotlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-goods-index">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Yangi maxsulot kiritish', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </p>
    <br>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'product_category',
                'value' => 'productCategory.name'
            ],
            [
                'attribute' => 'amount',
                'value' => function ($model) {
                    return $model->amount . ' ' . $model->weightType->name;
                }
            ],
            'initial_price',
            [
                'attribute' => 'created_at',
                'value' =>function($model) {
                    return date('d-m-Y H:i',$model->created_at);
                }
            ],
            'createdPerson.username',
            //'updated_at',
            //'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
