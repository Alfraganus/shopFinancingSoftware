<?php

use yii\widgets\ActiveForm;
?>
<?php if (\app\models\SalesOverallPayment::find()->where(['sale_id'=>$_GET['sale_id']])->exists()): ?>
<div class="alert alert-warning">
    <strong>Ushbu xarid yakunlangan!</strong>
</div>
<?php else : ?>
<?php $form = ActiveForm::begin(); ?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-check"></i>  <?= Yii::$app->session->getFlash('success') ?></h4>

    </div>
<?php endif; ?>

<div class="row">
    <!-- Left column -->
    <div class="col-md-8">
        <h1 style="text-align: center"><?= substr($_GET['sale_id'], -4) ?> raqamli xarid ro'yxati</h1>
        <table class="table table-striped">
            <thead>
            <tr>
                <th></th>
                <th>Maxsulotlar</th>
                <th>Miqdori</th>
                <th>Narxi</th>
                <th></th>
            </tr>
            </thead>
            <tbody
            <?php foreach ($sales as $index => $sale): $index++ ?>
                <tr>
                    <td><?=$index?></td>
                    <td><?=$sale->productCategory->name?></td>
                    <td><?=$sale->quantity?> <?=$sale->newgoods->weightType->name?></td>
                    <?php if(!empty($sale->price->price)): ?>
                        <td>(1x = <?=$sale->price->price?>)  <span style="color:orangered"> <?=$sale->quantity?>x</span> = <?= number_format($sale->price->price*$sale->quantity)?> so'm</td>
                    <?php else : ?>
                        <td>Ushbu maxsulot uchun narx mavjud emas</td>
                    <?php endif;?>
                    <td>
                        <a href="<?=\yii\helpers\Url::to(['site/cancel-sale','id'=>$sale->id])?>">
                        <span  class="btn btn-danger">Maxsulotni bekor qilish</span></td>
                    </a>

                </tr>
                <?php $overallPrice['sum'] += $sale->price->price*$sale->quantity?>
            <?php endforeach;?>
            <tr>
                <td colspan="3">Umumiy xisob: <span style="color:darkred"><?= number_format($overallPrice['sum'])?> so'm</span></td>
            </tr>
        </table>
        <div class="col-md-12">
            <?= $form->field($model, 'paymentData')->widget(\unclead\multipleinput\MultipleInput::className(), [
                'max' => 4,
                'columns' => [
                    [
                        'name'  => 'payment_type',
                        'type'  => 'dropDownList',
                        'title' => 'To\'lov turi',
                        'defaultValue' => 1,
                        'items' => [
                            1 => 'Naqd pul',
                            2 => 'Plastik karta',
                            3 => 'Nasiya',
                        ]
                    ],

                    [
                        'name'  => 'amount',
                        'title' => 'Miqdori',
                        'enableError' => true,
                        'defaultValue' =>$overallPrice['sum'],
                        'options' => [
                            'class' => 'input-priority',

                        ]
                    ]
                ]
            ])->label(false);
            ?>
            <?= $form->field($model, 'payment_amount_post')->hiddenInput(['value'=>$overallPrice['sum']])->label(false);?>
        </div>
    </div>




    <!-- /Left column -->

    <!-- Right column -->
    <div class="col-md-4">
<p style="padding: 10px;text-align: center;font-size: 16px">Nasiya uchun javobgar shaxs <span style="color:darkblue;font-weight: bold">(Nasiya bo'lgan xolatda to'ldiriladi)</span></p>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <?= $form->field($nasiya, 'nasiya_amount')->textInput();?>

                </div>
                <div class="form-group">
                    <?= $form->field($nasiya, 'fullname')->textInput();?>
                </div>
                <div class="form-group">
                    <?= $form->field($nasiya, 'phone')->textInput();?>
                </div>
                <div class="form-group">
                    <?= $form->field($nasiya, 'deadline')->textInput()->input('date');?>
                </div>
                <div class="form-group">
                    <?= $form->field($nasiya, 'responsible_person')->textInput();?>
                </div>
            </div>
        </div>
    </div>
    <!-- /Right column -->
</div>

<div class="mb-3 full-form-btns">
    <?= \yii\helpers\Html::submitButton('<i class="ri-check-line mr-1"></i>Xaridni yakunlash', ['class' => 'btn btn-success waves-effect btn-with-icon','name'=>'cpen']) ?>

    <!--  <button type="submit" name="cadd" class="btn btn-primary waves-effect btn-with-icon">
          <i class="ri-check-line mr-1"></i>
          Create & add another
      </button>-->

</div>
<?php ActiveForm::end(); ?>
<?php endif;?>
<script>
    var v = document.getElementById("user-status");
    v.className += " custom-select";

    var role = document.getElementById("user-role");
    role.className += " custom-select";

    var gender = document.getElementById("profile-user_gender");
    gender.className += " custom-select";
</script>
