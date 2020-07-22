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

            <h4 class="card-title mb-4">Xaridlar  <span style="color: blue">(Tolov turlari: 1 => Naqd to'lov  2=> Plastik to'lov  3=>Nasiya tolov)</span></h4>

            <?php $form = ActiveForm::begin(['action' => ['site/export-payments']]); ?>
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
                        <th>Xarid ID</th>
                        <th>Sana</th>
                        <th>Sotuvchi</th>
                        <th>Summa</th>
                        <th>To'lov turi</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($salePaymentTypes as $sale): ?>
                        <tr>

                            <td><a href="javascript: void(0);" class="text-dark font-weight-bold"><?=$sale->sale_id?></a> </td>
                            <td> <?= date('d-m-Y H:i',$sale->time)?> </td>
                            <td><?=$sale->salesman->saleperson->fullname?></td>
                            <td><?=number_format($sale->payment_amount)?> so'm</td>
                            <td>
                                <?php if($sale->payment_type == 1 ):?>
                                    <div class="badge badge-soft-success font-size-12">Naqt to'lov</div>
                                <?php elseif($sale->payment_type == 2) : ?>
                                    <div class="badge badge-soft-warning font-size-12">Plastik  to'lov</div>
                                <?php elseif($sale->payment_type == 3) : ?>
                                    <div class="badge badge-soft-danger font-size-12">Nasiya</div>
                                <?php endif;?>
                            </td>

                        </tr>
                    <?php endforeach;?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>