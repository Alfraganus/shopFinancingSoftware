<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\NewGoods */

$this->title ='yangi kelgan maxsulot nomi';
$this->params['breadcrumbs'][] = ['label' => 'New Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="new-goods-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Yangi kiritish', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Taxrirlash', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('O\'chirish', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php Yii::$app->formatter->nullDisplay = 'Ma\'lumot mavjud emas';?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'amount',
                'value' => function ($model) {
                    return $model->amount . ' ' . $model->weightType->name;
                }
            ],
            'initial_price',
            [
                'attribute'=>'created_at',
                'value'=> date('d-m-Y H:i',$model->created_at)
            ],
            [
                'attribute'=>'created_by',
                'value'=>$model->createdPerson->username
            ],
        ],
    ]) ?>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">Ushbu  maxsulot uchun qo'yilgan narxlar</h2>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th>1-narx</th>
                            <th>2-narx</th>
                            <th>3-narx</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <?php foreach ($productPrices as $price): ?>
                            <th style="font-size: 18px"><b><?=$price->price?></b></th>
                       <?php endforeach; ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
