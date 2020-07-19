<?php
$this->title = 'Statistikalar';
use yii\widgets\ActiveForm;
?>


<!-- start page title -->
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Statistikalar sahifasi <span style="color: orange">(muddat belgilanmagan holatda bugungi kunni ko'rsatadi!)</span> </h4>

            <div class="col-2" style="text-align: right;font-weight: bold;font-size: 16px;color: #3848ca">Muddat belgilash</div>
            <div class="col-3">
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
            <div class="col-2">
              <span id="dateButton" onclick="sendDate()" class="btn btn-primary">Ko'rsatish</span>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body overflow-hidden">
                                <p class="text-truncate font-size-14 mb-2">Umumiy savdo kirimi:</p>
                                <div id="overall"></div>


                            </div>
                            <div class="text-primary">
                                <i class="ri-stack-line font-size-24"></i>
                            </div>
                        </div>
                    </div>

                    <div class="card-body border-top py-3">
                        <div class="text-truncate">

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body overflow-hidden">
                                <p class="text-truncate font-size-14 mb-2">Plastikdan tushgan kirim</p>
                                <div id="plastik"></div>
                            </div>
                            <div class="text-primary">
                                <i class="ri-stack-line font-size-24"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top py-3">
                        <div class="text-truncate">

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body overflow-hidden">
                                <p class="text-truncate font-size-14 mb-2">Naqd puldan tushgan kirim</p>
                                <div id="naqd"></div>
                            </div>
                            <div class="text-primary">
                                <i class="ri-stack-line font-size-24"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top py-3">
                        <div class="text-truncate">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body overflow-hidden">
                                <p class="text-truncate font-size-14 mb-2">Nasiya Savdo</p>
                                <div id="nasiya"></div>
                            </div>
                            <div class="text-primary">
                                <i class="ri-stack-line font-size-24"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top py-3">
                        <div class="text-truncate">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="float-right d-none d-md-inline-block">

                        </div>
                        <h4 class="card-title mb-4">Ohirgi 10 kunlikda yangi kelgan maxsulot va sotilgan maxsulot</h4>
                        <div>
                            <div id="timeBasedChart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-4">To'lov turlari</h4>

                        <div id="chartPaymentTypes" class=""></div>


                    </div>
                </div>


            </div>

        </div>
<!-- end row -->

<div class="row">

    <div class="col-lg-4">
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

                <h4 class="card-title mb-4">Nasiyaga olingan maxsulotlar maxsulotlar</h4>

                <div data-simplebar style="max-height: 330px;">
                    <ul id="listActivity" class="list-unstyled activity-wid"> </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
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

                <h4 class="card-title mb-4">Xaridlar </h4>

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
                            <td><?=number_format($sale->payment_amount)?></td>
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
</div>
<!-- end row -->

<div class="row">


</div>

<style>
    .range-value {
        margin-left: 10px !important;
    }
</style>

