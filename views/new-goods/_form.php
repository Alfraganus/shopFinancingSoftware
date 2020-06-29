<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NewGoods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="new-goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
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
            <?= $form->field($model, 'amount_type')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\AmountTypes::find()->all(),'id','name')) ?>

        </div>
    </div>

    <div class="row">
<?php for ($i=1;$i<=3;$i++): ?>
        <div class="col-md-4">
            <label for="example-text-input" class="control-label">Maxsulot uchun <?=$i?>-narx</label>
            <input class="form-control" type="text" name="price[]"  placeholder="<?=$i?>-narx">
        </div>
        <?php endfor;?>
    </div>
<br>






    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
