<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Topshirilmagan xaridlar</a></li>
    <li><a data-toggle="tab" href="#menu1">Egasiga topshirib bo'lingan xaridlar</a></li>

</ul>

<div class="tab-content">
    <div id="home" class="tab-pane fade in active">
        <h3>Topshirilmagan xaridlar</h3>
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Xarid id</th>
                    <th>Sotuvchi</th>
                    <th>Kassir</th>
                    <th>Umumiy xisob</th>
                    <th>vaqt</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($finishedSales as $sale): ?>
                    <?php $personName = \app\models\Sales::find()->where(['sale_id'=>$sale->sale_id])->orderBy('id DESC')->one(); ?>
                    <tr>
                        <td><?= substr($sale->sale_id, -4);?></td>
                        <td><?= $personName->saleperson->fullname?></td>
                        <td><?= $personName->overallPrice->person->fullname?></td>

                        <td><?= number_format($personName->overallPrice->payment_amount)?> so'm</td>
                        <td><?= date('d-m-Y H:i',$personName->overallPrice->date)?></td>

                        <td><a target="_blank" href="<?=\yii\helpers\Url::to(['site/view-sale','sale_id'=>$sale->sale_id])?>">
                                <i class="fa fa-eye" style="color: blue;font-size: 22px" aria-hidden="true"></i> ko'rish
                            </a>
                        </td>

                        <td><a target="_blank" href="<?=\yii\helpers\Url::to(['site/warehouse-give-procuts','sale_id'=>$sale->sale_id])?>">
                                <i class="fa fa-check" aria-hidden="true"></i> Topshirish
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
    <div id="menu1" class="tab-pane fade">
        <h3>Egasiga topshirilgan maxsulotlar</h3>
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Xarid id</th>
                    <th>Sotuvchi</th>
                    <th>Kassir</th>
                    <th>Umumiy xisob</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($givenSales as $sale): ?>
                    <?php $personName = \app\models\Sales::find()->where(['sale_id'=>$sale->sale_id])->orderBy('id DESC')->one(); ?>
                    <tr>
                        <td><?= substr($sale->sale_id, -4);?></td>
                        <td><?= $personName->saleperson->fullname?></td>
                        <td><?= $personName->overallPrice->person->fullname?></td>
                        <td><?= number_format($personName->overallPrice->payment_amount)?> so'm</td>
                        <td><a target="_blank" href="<?=\yii\helpers\Url::to(['site/view-sale','sale_id'=>$sale->sale_id])?>">
                                <i class="fa fa-eye" style="color: blue;font-size: 22px" aria-hidden="true"></i> ko'rish
                            </a>
                        </td>
                        <td>
                                <i style="color: green" class="fa fa-check" aria-hidden="true"></i> Topshirildi
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>

</div>
</div>



<style>
    .btn-primary a {
        color:white !important;
    }
</style>