<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use unclead\multipleinput\MultipleInput;
/* @var $this yii\web\View */
/* @var $model app\models\ProductCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    if ($model->isNewRecord) {
        echo $form->field($model, 'name')->widget(MultipleInput::className(), [
            'max' => 50,
            'min' => 1, // should be at least 2 rows
            'allowEmptyList' => false,
            'enableGuessTitle' => true,
            'addButtonPosition' => MultipleInput::POS_HEADER, // show add button in the header
        ])
            ->label(false);
    } else {
       echo  $form->field($model, 'name')->textInput() ;
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<style>
    .btn-default
    {
        background: green !important;
        color:white;
    }
</style>