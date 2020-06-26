<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
<?php if ($model->isNewRecord) : ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
<?php endif;?>
    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Roles::find()->all(),'id','name')) ?>

    <?= $form->field($model, 'status')->dropDownList([
            10=>'Aktiv',
            0=>'NoAktiv',
            5=>'Blok'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
