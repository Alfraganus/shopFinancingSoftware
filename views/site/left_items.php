<?php if(\app\models\ProductsQuantity::find()->sum('quantity')>0 ):?>
<h1 class="card-title text-center">Xozirda omborda mavjud bo'lgan maxsulotlar</h1>

<div class="table-responsive">
    <table class="table mb-0">

        <thead class="thead-light">

        <tr>
            <th>#</th>
            <th>Maxsulot nomi</th>
            <th>Miqdori</th>

        </tr>
        </thead>
        <tbody>

        <?php foreach ($products as $pro): ?>
        <tr>
            <th scope="row">1</th>
            <td><?=$pro->productCategory->name?></td>
            <td><?=$pro->quantity?> <?= $pro->productInfo->weightType->name?> </td>

        </tr>
        <?php endforeach;?>
        <?php else : ?>
        <div class="alert alert-danger">
            <strong>Omborda maxsulot qolmadi!</strong>
        </div>
        <?php endif;?>

        </tbody>
    </table>
</div>