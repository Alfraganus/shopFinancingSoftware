
<?php if(count($sales)>0): ?>
<h1 style="text-align: center">So'ngi xaridlar</h1>
<table class="table table-striped">

    <thead>
    <tr>
        <th>Xarid id</th>
        <th>Sotuvchi</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($sales as $sale): ?>
    <?php $personName = \app\models\Sales::find()->where(['sale_id'=>$sale->sale_id])->one(); ?>
    <tr>
        <td><?= substr($sale->sale_id, -4);?></td>
        <td><?= $personName->saleperson->fullname?></td>
        <td><a href="<?=\yii\helpers\Url::to(['site/kassir-sale','sale_id'=>$sale->sale_id  ])?>"><button class="btn btn-primary">Xaridni davom ettirish</a></button></td>
    </tr>
    <?php endforeach; ?>

    </tbody>
</table>
<?php else: ?>
    <div class="alert alert-danger">
        <strong>Yangi xarid topilmadi!</strong>
    </div>
<?php endif;?>
 
<h1 style="text-align: center;margin-top: 100px">Bugungi xaridlar</h1>
 
  <div class='row'>
   <div class="col-md-8">
  <input class="form-control" id="myInput" type="text" placeholder="Izlang..">
  </div>

  <div class="col-md-2">
    <iframe id="txtArea1" style="display:none"></iframe>
    <button style='width:100%' class="btb btn-primary pull-right" id="btnExport" onclick="fnExcelReport();"> Excel export </button>
</div>
</div>
<table id='dataexport' class="table table-striped">

    <thead>
    <tr>
        <th>Xarid id</th>
        <th>Sotuvchi</th>
        <th>Umumiy xisob</th>
        <th>vaqt</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($finishedSales as $sale): ?>
        <?php $personName = \app\models\Sales::find()->where(['sale_id'=>$sale->sale_id])->orderBy('id DESC')->one(); ?>
        <tr>
            <td><?= substr($sale->sale_id, -4);?></td>
            <td><?= $personName->saleperson->fullname?></td>

            <td><?= number_format($personName->overallPrice->payment_amount)?> so'm</td>
            <td><?= date('d-m-Y H:i',$personName->overallPrice->date)?></td>
            <td><a href="<?=\yii\helpers\Url::to(['site/view-sale','sale_id'=>$sale->sale_id])?>">
                 <i class="fa fa-eye" style="color: blue;font-size: 22px" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
    <?php $saleAll+=$personName->overallPrice->payment_amount ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="3"><b>Umumiy summa:</b> <span style="color:darkred"> <?=number_format($saleAll)?> so'm</span></td>
    </tr>

    </tbody>
</table>
<style>
    .btn-primary a {
        color:white !important;
    }
</style>

<script>

    function fnExcelReport()
    {
        var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
        var textRange; var j=0;
        tab = document.getElementById('dataexport'); // id of table

        for(j = 0 ; j < tab.rows.length ; j++)
        {
            tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
            //tab_text=tab_text+"</tr>";
        }

        tab_text=tab_text+"</table>";
        tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
        tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open("txt/html","replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa=txtArea1.document.execCommand("SaveAs",true,"maxsulotlar.xls");
        }
        else                 //other browser not tested on IE 11
            sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

        return (sa);
    }
    
    $(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#dataexport tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>