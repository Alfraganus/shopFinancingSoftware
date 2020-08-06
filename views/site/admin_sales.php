<?php
use yii\widgets\ActiveForm;
?>
<h4 class="card-title mb-4">Xaridlar </h4>
<?php $form = ActiveForm::begin(); ?>
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
<div class="col-md-3">

    <button type="submit" class="btn btn-primary">Malumotlarni ko'rsatish</button>
    <span style="cursor: pointer" class="btn btn-info" onclick="exportTableToExcel('dataExport')">Tablitsani export qilish </span>
</div>

</div>
<?php ActiveForm::end(); ?>


<div class="table-responsive">
    <table id="dataExport" class="table table-centered datatable dt-responsive nowrap" data-page-length="5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="thead-light" >
        <tr>
            <th >Maxsulot nomi</th>
            <th>Sanog'i</th>
            <th>Sotilgan summa</th>
            <th>Xisoblangan summa </th>
            <th>Sotuvchi foydasi</th>
            <th>Hamkor foydasi</th>
            <th>Sotib olin(ma)di</th>
            <th>Sotuvchi</th>
            <th>Vaqt</th>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($salesRecords as $sale): ?>
        <?php if($sale->accountant_confirm == 10): ?>
        <?php
        $sotilganSumma +=$sale->price->price*$sale->quantity;
         $sotuvchiFoydasi +=($sale->price->price*$sale->quantity)-(($sale->quantity)*($minPriceModel->findMinPrice($sale->product_category)));
         $xisoblanganSumma +=($sale->quantity)*($minPriceModel->findMinPrice($sale->product_category));
         $hamkorFoydasi +=$sale->price->price*$sale->quantity-($sale->newgoods->initial_price*$sale->quantity);
            ?>
            <tr>

                <td class="text-dark font-weight-bold"><?=$sale->productCategory->name?> </td>
                <td> <?= $sale->quantity?> </td>
                <td><?= number_format($sale->price->price*$sale->quantity)?> so'm</td>
		  <td><?= number_format(($sale->quantity)*($minPriceModel->findMinPrice($sale->product_category)))?> so'm</td>
		<td><?= number_format(($sale->price->price*$sale->quantity)-(($sale->quantity)*($minPriceModel->findMinPrice($sale->product_category))))?> so'm</td>
                <td> <?=number_format($sale->price->price*$sale->quantity-($sale->newgoods->initial_price*$sale->quantity))?> so'm</td>
<td>
                    <?php if($sale->accountant_confirm == 10 ):?>
                        <div class="badge badge-soft-success font-size-12">Sotib olindi</div>
                    <?php elseif($sale->accountant_confirm == null) : ?>
                        <div class="badge badge-soft-danger font-size-12">Sotib olinmadi</div>
                    <?php endif;?>
                </td>
                <td><?=$sale->saleperson->fullname?></td>
                <td><?=date('d-m-Y H:i',$sale->time)?> </td>

            </tr>
        <?php endif?>
        <?php endforeach;?>
        <tr style="color:white;background: black">
            <td style="font-size: 22px">Umumiy:</td>
            <td></td>
            <td><?=number_format($sotilganSumma)?> so'm</td>
            <td><?=number_format($xisoblanganSumma)?> so'm</td>
            <td><?=number_format($sotuvchiFoydasi)?> so'm</td>
            <td><?=number_format($hamkorFoydasi)?> so'm</td>
            <td colspan="3"></td>
        </tr>


        </tbody>
    </table>
</div>

<script>
    function fnExcelReport()
    {
        var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
        var textRange; var j=0;
        tab = document.getElementById('dataExport'); // id of table

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

    function exportTableToExcel(tableID, filename = 'Savdolar'){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

        // Specify file name
        filename = filename?filename+'.xls':'excel_data.xls';

        // Create download link element
        downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);

        if(navigator.msSaveOrOpenBlob){
            var blob = new Blob(['\ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob( blob, filename);
        }else{
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

            // Setting the file name
            downloadLink.download = filename;

            //triggering the function
            downloadLink.click();
        }
    }
</script>