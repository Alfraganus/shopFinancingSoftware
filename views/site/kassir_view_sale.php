
<i onclick="window.print()" style="float: right;font-size: 26px" class="fa fa-print" aria-hidden="true"></i>
<h1 style="text-align: center"><?= substr($_GET['sale_id'], -4) ?> raqamli xarid yakunlandi</h1>


<table class="table table-striped">
    <thead>
    <tr>
        <th></th>
        <th>Maxsulotlar</th>
        <th>Miqdori</th>
        <th>Narxi</th>
    </tr>
    </thead>
    <tbody
    <?php foreach ($sales as $index => $sale): $index++ ?>
    <?php
        $salePerson = $sale->saleperson->fullname;
        $cashier =$sale->overallPrice->person->fullname;
        $time = date('d-m-Y H:i', $sale->overallPrice->date);
        ?>
        <tr>
            <td><?=$index?></td>
            <td><?=$sale->productCategory->name?></td>
            <td><?=$sale->quantity?> <?=$sale->newgoods->weightType->name?></td>
            <?php if(!empty($sale->price->price)): ?>
                <td>(1x = <?=$sale->price->price?>)  <span style="color:orangered"> <?=$sale->quantity?>x</span> = <?= number_format($sale->price->price*$sale->quantity)?> so'm</td>
             <?php endif;?>

        </tr>
        <?php $overallPrice['sum'] += $sale->price->price*$sale->quantity?>
    <?php endforeach;?>

</table>
<div class="row">
    <div class="col-md-6">
        <p>Umumiy xisob: <span style="color:darkred"><?= number_format($overallPrice['sum'])?> so'm</span></p>
        <p>Sotuchi: <span style="color:darkred"><?=$salePerson?> </span></p>
    </div>
    <div class="col-md-6">
        <p>Kassir: <span style="color:darkred"><?= $cashier?> </span></p>
        <p>Vaqt: <span style="color:darkred"><?= $time?></span></p>
    </div>
</div>
 <span style="color:darkred">Sotilgan maxsulotlar faqat 10 kun ichida qaytarib olinadi !!!</span>



<style>
    .fa-print {
        cursor: pointer;
    }
</style>