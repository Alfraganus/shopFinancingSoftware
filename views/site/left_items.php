<?php if(\app\models\ProductsQuantity::find()->sum('quantity')>0 ):?>
<h1 class="card-title text-center">Xozirda omborda mavjud bo'lgan maxsulotlar</h1>

  <h2>Maxsulotni izlash</h2>
  <div class='row'>
   <div class="col-md-8">
  <input class="form-control" id="myInput" type="text" placeholder="Search..">
  </div>

  <div class="col-md-2">

    <iframe id="txtArea1" style="display:none"></iframe>
    <button style='width:100%' class="btb btn-primary pull-right" id="btnExport" onclick="fnExcelReport();"> Excel export </button>
</div>
</div>
  <br>
<div class="table-responsive">
    <table id="dataexport" class="table mb-0">
        <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Maxsulot nomi</th>
            <th>Miqdori</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($products as $pro): ?>
	<?php $index++?>        
<tr>
            <th scope="row"><?=$index?></th>
            <td><?=$pro->productCategory->name?></td>
            <td><?=$pro->quantity?> <?= $pro->productInfo->weightType->name?> </td>

        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>

<?php else : ?>
    <div class="alert alert-danger">
        <strong>Omborda maxsulot qolmadi!</strong>
    </div>
<?php endif;?>
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