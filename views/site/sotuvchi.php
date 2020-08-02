<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\NewGoods */
/* @var $form yii\widgets\ActiveForm */
$randNumber = date('md').rand(0,999);
?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 text-center"><?= date('d-m-Y')?> kungi sotuvlar ro'yxati</h4>



        </div>
        <a href="<?=Url::to(['site/sale-list','rand'=>$randNumber])?>"> <button type="button" class="btn btn-primary waves-effect waves-light float-md-right">Yangi xarid qo'shish</button></a>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive-md">
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Maxsulot nomi</th>
                        <th>Miqdori</th>
                        <th>Vaqt</th>
                        <th>xarid ID</th>
                        <th></th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sales as $key => $sale): $key++ ?>
                    <?php if(date('d',$sale->time)==date('d') ): ?>
                    <tr>
                        <td><?=$key?></td>
                        <td><?=$sale->productCategory->name?></td>
                        <td><?=$sale->quantity?> <?=$sale->newgoods->weightType->name?></td>
                        <td><?=date('d-m-Y H:i',$sale->time)?></td>
                        <td><?= substr($sale->sale_id, -4);?></td>
                        <td>
                            <?php if($sale->accountant_confirm==null):?>
                            <div class="alert alert-warning">
                                <strong>Xarid kassir tomonidan tasdiqlanmadi!</strong>
                            </div>
                            <?php elseif($sale->accountant_confirm==10):?>
                            <div class="alert alert-success">
                                <strong>Xarid tasdiqlandi</strong>
                            </div>
                            <?php endif;?>
                        </td>
                        <?php if($sale->accountant_confirm==null): ?>
                        <td><a href="<?=Url::to(['site/sale-list','rand'=>$sale->sale_id])?>"><button class="btn btn-primary">Xarid ichiga kirish</button></a></td>
                        <?php endif; ?>
                    </tr>
                    <?php endif;?>
                    <?php endforeach; ?>

                    </tbody>
                </table>
                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->


