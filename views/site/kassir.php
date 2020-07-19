
<?php if(count($sales)>0): ?>
<h1 style="text-align: center">So'ngi xaridlar</h1>
<table class="table table-striped">

    <thead>
    <tr>
        <th>Xarid id</th>
        <th>Sotuvchi</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($sales as $sale): ?>
    <?php $personName = \app\models\Sales::find()->where(['sale_id'=>$sale->sale_id])->one(); ?>
    <tr>
        <td><?= substr($sale->sale_id, -4);?></td>
        <td><?= $personName->saleperson->fullname?></td>
        <td><a href="<?=\yii\helpers\Url::to(['site/kassir-sale','sale_id'=>$sale->sale_id  ])?>"><button class="btn btn-primary">Xaridni davom ettirish</a></button></td>
    </tr>
    <?php endforeach; ?>

    </tbody>
</table>
<?php else: ?>
    <div class="alert alert-danger">
        <strong>Yangi xarid topilmadi!</strong>
    </div>
<?php endif;?>

<h1 style="text-align: center;margin-top: 100px">Tugallangan xaridlar</h1>

<table class="table table-striped">

    <thead>
    <tr>
        <th>Xarid id</th>
        <th>Sotuvchi</th>
        <th>Umumiy xisob</th>
        <th>vaqt</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($finishedSales as $sale): ?>
        <?php $personName = \app\models\Sales::find()->where(['sale_id'=>$sale->sale_id])->orderBy('id DESC')->one(); ?>
        <tr>
            <td><?= substr($sale->sale_id, -4);?></td>
            <td><?= $personName->saleperson->fullname?></td>

            <td><?= number_format($personName->overallPrice->payment_amount)?> so'm</td>
            <td><?= date('d-m-Y H:i',$personName->overallPrice->date)?></td>
            <td><a href="<?=\yii\helpers\Url::to(['site/view-sale','sale_id'=>$sale->sale_id])?>">
                 <i class="fa fa-eye" style="color: blue;font-size: 22px" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
    <?php $saleAll+=$personName->overallPrice->payment_amount ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="3"><b>Umumiy summa:</b> <span style="color:darkred"> <?=$saleAll?> so'm</span></td>
    </tr>

    </tbody>
</table>
<style>
    .btn-primary a {
        color:white !important;
    }
</style>