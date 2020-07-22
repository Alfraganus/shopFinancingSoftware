<?php
use yii\widgets\ActiveForm;
?>
<div class="col-lg12">
    <div class="card">
        <div class="card-body">
            <div class="dropdown float-right">
                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                </div>
            </div>

            <h4 class="card-title mb-4">Nasiya xaridlar </h4>
            <?php $form = ActiveForm::begin(['action' => ['site/export-nasiya']]); ?>
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
                        <th>Nasiyachi</th>
                        <th>Nasiya summasi</th>
                        <th>Telefon raqami</th>
                        <th>Qaytarish sanasi</th>
                        <th>Kafil shaxs</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($nasiya as $sale): ?>
                        <tr>

                            <td><?=$sale->fullname?> </td>
                            <td> <?= $sale->nasiya_amount?> </td>
                            <td> <?= $sale->phone?> </td>
                            <td><?=$sale->deadline?></td>
                            <td> <?= $sale->responsible_person?> </td>


                        </tr>
                    <?php endforeach;?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>