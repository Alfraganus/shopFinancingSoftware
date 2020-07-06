<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\NewGoods */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="new-goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-6">

            <?= $form->field($model, 'product_category')->widget(Select2::classname(), [
                'data' => [ArrayHelper::map(\app\models\ProductCategory::find()->all(),'id','name')],
                'options' => ['placeholder' => 'Maxsulot nomini kiriting ...'],
            ])->label('Maxsulot nomi'); ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'initial_price')->textInput()?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'amount')->textInput() ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'amount_type')->widget(Select2::classname(), [
                'data' => [ArrayHelper::map(\app\models\AmountTypes::find()->all(),'id','name')],
                'options' => ['placeholder' => 'O\'g\'irlik o\'lchovini tanlang...'],
            ])->label('O\'g\'irlik o\'lchovi'); ?>

        </div>


    </div>

    <div class="row">
        <?php if ($model->isNewRecord): ?>

        <?php for ($i = 1; $i <= 3; $i++): ?>
            <div class="col-md-4">
                <label for="example-text-input" class="control-label">Maxsulot uchun <?= $i ?>-narx</label>
                <input class="form-control" type="text" name="price[]" placeholder="<?= $i ?>-narx">
            </div>
        <?php endfor; ?>

        <?php else : ?>
        <?php $i=0; foreach ($productPrices as $price): $i++; ?>

            <div class="col-md-4">
                <label for="example-text-input" class="control-label">Maxsulot uchun <?= $i ?>-narx</label>
                <input class="form-control" type="text" name="oldprice[]" value="<?= $price->price ?>">

            </div>
        <?php endforeach; ?>
        <?php endif;?>

    </div>
<br>






    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
    .select2-selection--single,.select2-selection__rendered {
        line-height: 15px !important;
    }
    .select2-selection--single, .select2-selection__arrow {
        height: 26px !important;
    }
</style>