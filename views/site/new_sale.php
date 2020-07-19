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
?>


<div class="sale">
    <?php $form = ActiveForm::begin(); ?>
    <input type="hidden" name="SampleInformation" >

    <?= $form->field($model,'product_category')->widget(MultipleInput::class,[
        'max' => 16,
        'cloneButton' => true,
        'allowEmptyList'=> false,
        'columns' => [
            [
                'name' => 'product_category',
                'type' => \kartik\select2\Select2::class,
                'title' => 'Maxsulot nomi <font color="red">*</font>',
                'options' => [
                    'id'=>'catid',
                    'name' => 'category',
                    'value' => '',
                    'data' => $data,

                    'options' => [
                        'placeholder' => 'Maxsulot nomini tanlang ...',
                        'enableError' => true,
                        'onchange' => '
                       $.post(
                "' . \yii\helpers\Url::toRoute('getoperations') . '", 
                {id: $(this).val()}, 
                function(res){
                    $(".emeliyyatlar").html(res);
                }
            );
                      ',
                    ]
                ]

            ],
            [
                'name' => 'price',
                'type' => 'dropdownlist',
                'enableError'=>true,
                'title' => 'Maxsulot Narxi <font color="red">*</font>',
                'items' => [],
                'options' => [
                    'class' => 'emeliyyatlar',
                    'name' => 'price',
                    'value' => '',
                    'options' => ['placeholder' => 'Narxni tanlang.. ...','prompt'=>'narxni tanlang'],

                ]

            ],
            [
                'name' => 'quantity',
                'title' => 'Miqdori <font color="red">*</font>',

            ],


        ]
    ])
        ->label(false);
    ?>
  <button class="btn btn-primary" type="submit">Xaridni yakunlash</button>
<?php ActiveForm::end(); ?>



<style>
    .select2-container, .select2-selection--single, .select2-selection__rendered {
        line-height: 12px !important;
    }
    .select2-selection__arrow {
        height: 26px !important;
    }
</style>

