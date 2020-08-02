<?php
use yii\widgets\ActiveForm;
?>
<h4 class="card-title mb-4">Xaridlar </h4>
<?php $form = ActiveForm::begin(['action' => ['site/export-sales']]); ?>
<div class="row">

<div class="col-md-3">
    <?php
    echo '<div class="drp-container">';
    echo \kartik\daterange\DateRangePicker::widget([
        'name'=>'date_range_2',
        'bsVersion' => '4.x',
        'presetDropdown'=>true,
        'convertFormat'=>true,
        'includeMonthsFilter'=>true,
        'pluginOptions' => ['locale' => ['format' => 'd-m-Y']],
        'options' => ['placeholder' => 'Oraliq muddat tanlang!...'],

    ]);
    echo '</div>'; ?>
</div>
<div class="col-md-2">
    <button class="btn btn-primary">Excelga export qilish</button>
</div>

</div>
<?php ActiveForm::end(); ?>
<div class="table-responsive">
    <table class="table table-centered datatable dt-responsive nowrap" data-page-length="5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="thead-light">
        <tr>
            <th>Maxsulot nomi</th>
            <th>Sanog'i</th>
            <th>Umumiy summa</th>
            <th>Sotilgan summa </th>
            <th>Sotilishi kerek bo'lgan summa</th>
            <th>Sotib olin(ma)di</th>
            <th>Sotuvchi</th>
            <th>Vaqt</th>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($salesRecords as $sale): ?>
            <tr>

                <td class="text-dark font-weight-bold"><?=$sale->productCategory->name?> </td>
                <td> <?= $sale->quantity?> </td>
                <td><?= number_format($sale->price->price*$sale->quantity)?> so'm</td>
                <td><?= number_format($sale->price->price)?> so'm</td>
                <td><?=number_format($minPriceModel->findMinPrice($sale->product_category))?> so'm</td>
                <td>
                    <?php if($sale->accountant_confirm == 10 ):?>
                        <div class="badge badge-soft-success font-size-12">Sotib olindi</div>
                    <?php elseif($sale->accountant_confirm == null) : ?>
                        <div class="badge badge-soft-warning font-size-12">Sotib olinmadi</div>
                    <?php endif;?>
                </td>
                <td><?=$sale->saleperson->fullname?></td>
                <td><?=date('d-m-Y H:i',$sale->time)?> </td>

            </tr>
        <?php endforeach;?>


        </tbody>
    </table>
</div>