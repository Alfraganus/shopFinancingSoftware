<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use unclead\multipleinput\MultipleInput;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\NewGoods */
/* @var $form yii\widgets\ActiveForm */
$data = ArrayHelper::map(\app\models\ProductCategory::find()->all(),'id','name');
$price = ArrayHelper::map(\app\models\ProductPrices::find()->all(),'id','price');
$is_finished = \app\models\Sales::findone(['sale_id'=>$_GET['rand']]);
?>


<div class="sale">
    <?php $form = ActiveForm::begin(); ?>
    <h1 class="float-left"><i style="color: darkred" class="fa fa-university" aria-hidden="true"></i>:  <span style="color: darkred;font-weight: bold" id="inStock"></span></h1>
    <h1 class="float-right"><i style="color: darkred" class="fa fa-handshake" aria-hidden="true"></i>: <span style="color: darkred;font-weight: bold" id="unconfirmedQuantity"></span></h1>
    <div style="clear: both"></div>
<div class="row" style="display:<?=($is_finished->is_finished ==10)?'none':''?>">

    <div class="col-md-4">
        <?= $form->field($model, 'product_category')->widget(Select2::classname(), [
            'options' => ['placeholder' => 'Maxsulot tanlang ...'],
            'data' => ArrayHelper::map(\app\models\ProductCategory::find()->asArray()->all(), 'id', 'name')
        ]); ?>
    </div>
    <div class="col-md-4">
        <div class="my-new-list"></div>
        <?= $form->field($model, 'quantity')->textInput()?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'price_id')->widget(\kartik\depdrop\DepDrop::classname(), [
            'options' => ['placeholder' => 'Narxni tanlang ...'],
            'type' => \kartik\depdrop\DepDrop::TYPE_SELECT2,
            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
            'pluginOptions' => [
                'depends' => ['sales-product_category'],
                'url' => \yii\helpers\Url::to(['/site/getprice']),
                'loadingText' => 'Loading child level 1 ...',
            ]
        ]);?>
    </div>





    <button style="font-size: 20px;" class="btn btn-primary pull-right" type="submit">Savatchaga qo'shish</button>
    <?php ActiveForm::end(); ?>
</div>

    <br>

    <h1 style="text-align: center;color: blue"><i style="color: blue" class="fa fa-shopping-cart" aria-hidden="true"></i> <?=substr($_GET['rand'],-4)?></h1>
    <?php if(count($sales)>0): ?>
        <a style="display:<?=($is_finished->is_finished ==10)?'none':''?>" href="<?=\yii\helpers\Url::to(['finish-sale','sale_id'=>$_GET['rand']])?>"><button style="font-size: 20px" class="btn btn-danger"><i class="fa fa-backward" aria-hidden="true"></i> Savdoni yakunlash va qaytish</button></a>


    <div class="table-responsive-md">
    <table class="table table-striped">
        <thead>
        <tr>
            <th></th>
            <th>Maxsulot nomi</th>
            <th>Miqdori</th>
            <th>Narxi</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($sales as $index => $sale): $index++ ?>
        <tr>
            <td><?=$index?></td>
            <td><?=$sale->productCategory->name?></td>
            <td><?=$sale->quantity?> <?=$sale->newgoods->weightType->name?></td>
            <?php if(!empty($sale->price->price)): ?>
            <td> <?= number_format($sale->price->price*$sale->quantity)?> so'm</td>
            <?php else : ?>
            <td>Ushbu maxsulot uchun narx mavjud emas</td>
            <?php endif;?>
            <td>
                <a href="<?=\yii\helpers\Url::to(['site/cancel-sale','id'=>$sale->id])?>">
                    <button style="font-size: 18px" class="btn btn-warning"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                </a>
            </td>
        </tr>
        <?php $overallPrice['sum'] += $sale->price->price*$sale->quantity?>
        <?php endforeach;?>
<tr>

    <td colspan="3">Umumiy xisob: <span style="color:darkred"><?= number_format($overallPrice['sum'])?> so'm</span></td>
</tr>
        </tbody>
    </table>
    </div>
    <?php endif?>

    <style>
        .select2-container, .select2-selection--single, .select2-selection__rendered {
            line-height: 12px !important;
        }
        .select2-selection__arrow {
            height: 26px !important;
        }
        td {
            font-size: 18px !important;
        }

    </style>


    <script>

        $('#sales-product_category').change(function () {
            val = $(this).find(":selected").val();
            $.ajax({
                type: "POST",
                url: "<?php echo Yii::$app->getUrlManager()->createUrl('site/quantity')  ; ?>",
                data: {
                    val: val,
                },
                success: function (res) {
                  console.log(res);
                  if(res['in_stock']===null)
                  {
                      document.getElementById('inStock').innerHTML='Omborda mavjud emas';
                  } else {
                      document.getElementById('inStock').innerHTML=res['in_stock']+' '+res['quantity'];
                  }

                  if(res['unconfirmed']==null) {
                      document.getElementById('unconfirmedQuantity').innerHTML=0;
                  } else {
                      document.getElementById('unconfirmedQuantity').innerHTML=res['unconfirmed'];
                  }
                    // location.reload();
                },
                error: function (exception) {
                    alert(exception);
                }
            })
        })
    </script>



