<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <?php if(count($products)>0 ):?>
            <h2 class="card-title">Yangi maxsulotlar tizimga kiritildi</h2>
            <p class="card-title-desc">Ushbu  maxsulotlarni o'z hisobingizga o'tkazish uchun<code>"tasdiqlash"</code>ni bosing.</p>

            <div class="table-responsive">
                <table class="table mb-0">

                    <thead class="thead-light">

                    <tr>
                        <th>#</th>
                        <th>Maxsulot nomi</th>
                        <th>Miqdori</th>
                        <th>Tizimga kiritilgan sana</th>
                        <th>Tasdiq</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($products as $pro): ?>
                    <tr>
                        <th scope="row">1</th>
                        <td><?=$pro->productCategory->name?></td>
                        <td><?=$pro->amount?> <?=$pro->weightType->name?></td>
                        <td><?= date('d-m-Y H:i',$pro->created_at)?></td>
                        <td><button id="clicked" onclick="sendFirstCategory(<?=$pro->id?>,<?=$pro->product_category?>,<?=$pro->amount?>)" class="btn btn-primary">Tasdiqlash</button></td>
                    </tr>
                    <?php endforeach;?>
                    <?php else : ?>
                        <div class="alert alert-danger">
                            <strong>Xozirda yangi maxsulotlar yo'q!</strong>
                        </div>
                    <?php endif;?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


<script>


    function sendFirstCategory(product_id,product_category,quantity) {
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::$app->getUrlManager()->createUrl('site/accept')  ; ?>",
            data: {
                product_id:product_id,
                product_category:product_category,
                product_quantity:quantity
            },
            success: function (test) {
                alert(test);
                location.reload();
            },
            error: function (exception) {
                alert(exception);
            }
        });
        return document.getElementById("clicked").disabled = true;
    }

</script>


