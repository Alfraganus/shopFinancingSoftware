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
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success">
                    <strong> <?= Yii::$app->session->getFlash('success') ?></strong>
                </div>

            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-centered datatable dt-responsive nowrap" data-page-length="5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead class="thead-light">
                    <tr>
                        <th>Nasiyachi</th>
                        <th>Nasiya summasi</th>
                        <th>Telefon raqami</th>
                        <th>Qaytarish sanasi</th>
                        <th>Kafil shaxs</th>
                        <th></th>
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
                            <td><a href="<?=\yii\helpers\Url::to(['nasiya-empty','id'=>$sale->id])?>"><button type="submit" class="btn btn-success">Qaytarildi!</button></a></td>


                        </tr>
                    <?php endforeach;?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>