
/*tolov turlari*/
var options = {
    chart: {
        height: 350,
        type: 'bar',
    },
    dataLabels: {
        enabled: false
    },
    labels: ['Plastik', 'Naqd pul', 'Nasiya'],
    series: [],
    noData: {
        text: 'Loading...'
    }
}

var chart = new ApexCharts(
    document.querySelector("#chartPaymentTypes"),
    options
);

chart.render();

var url = 'site/admin-dashboard';

$.getJSON(url, function(response) {
    chart.updateSeries([{
        name: 'Savdo',
        data: response['graphDatas']
    }]);

    var allSale =  response['sales'];
    var floatAllSale = parseFloat(allSale);
    document.getElementById("overall").innerHTML = "<h4 class='mb-0'>"+floatAllSale.toLocaleString({ style: 'currency', currency: 'UZS' }) +" so'm</h4>";


    var naqd =  response['naqd'];
    var naqdFloat = parseFloat(naqd);
    document.getElementById("naqd").innerHTML = "<h4 class='mb-0'>"+naqdFloat.toLocaleString({ style: 'currency', currency: 'UZS' }) +" so'm</h4>";

    var plastik =  response['plastik'];
    var plastikFloat = parseFloat(plastik);
    if(isNaN(plastikFloat))
    {
        document.getElementById("plastik").innerHTML = "<h4 class='mb-0'>0 so'm</h4>";
    } else {
        document.getElementById("plastik").innerHTML = "<h4 class='mb-0'>"+plastikFloat.toLocaleString({ style: 'currency', currency: 'UZS' }) +" so'm</h4>";
    }

    var nasiya =  response['nasiya'];
    var nasiyaFloat = parseFloat(nasiya);
    if(isNaN(nasiyaFloat))
    {
        document.getElementById("nasiya").innerHTML = "<h4 class='mb-0'>0 so'm</h4>";
    } else {
        document.getElementById("nasiya").innerHTML = "<h4 class='mb-0'>"+nasiyaFloat.toLocaleString({ style: 'currency', currency: 'UZS' }) +" so'm</h4>";
    }



});

function sendDate()
{
    var url = 'site/admin-dashboard';
    let requst = [10,30,50];
    var jsonString = JSON.stringify(requst);
    var date = document.getElementById('w1').value;
    $.ajax({
        type: "POST",
        url: url,
        data: {
            req:jsonString,
            date:date,
        },
        success: function (res) {

            console.log(res);
            $.getJSON(url, function(response) {
                chart.updateSeries([{
                    name: 'Savdo',
                    data: res['graphDatas']
                }])
            });
            var num =  res['sales'];
            if(num==null)
            {
                num =0;
            }

            var floatdata = parseFloat(num);
            document.getElementById("overall").innerHTML = "<h4 class='mb-0'>"+floatdata.toLocaleString({ style: 'currency', currency: 'UZS' }) +" so'm</h4>";

            var naqd =  res['naqd'];
            var naqdFloat = parseFloat(naqd);
            document.getElementById("naqd").innerHTML = "<h4 class='mb-0'>"+naqdFloat.toLocaleString({ style: 'currency', currency: 'UZS' }) +" so'm</h4>";

            var plastik =  res['plastik'];
            var plastikFloat = parseFloat(plastik);
            document.getElementById("plastik").innerHTML = "<h4 class='mb-0'>"+plastikFloat.toLocaleString({ style: 'currency', currency: 'UZS' }) +" so'm</h4>";

            var nasiya =  res['nasiya'];
            var nasiyaFloat = parseFloat(nasiya);
            if(isNaN(nasiyaFloat))
            {
                document.getElementById("nasiya").innerHTML = "<h4 class='mb-0'>0 so'm</h4>";
            } else {
                document.getElementById("nasiya").innerHTML = "<h4 class='mb-0'>"+nasiyaFloat.toLocaleString({ style: 'currency', currency: 'UZS' }) +" so'm</h4>";
            }


        },
        error: function (exception) {
            alert(exception);
        }
    });

}


/*vaqt oraligidagi tolovlar*/

var optionsTimeBased = {
    series: [{
        name:'Sotilgan maxsulotlar',
        type: 'area',
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
    }, {
        name: 'Yangi kelgan maxsulotlar',
        type: 'line',
        data: [00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
    }],
    chart: {
        height: 350,
        type: 'line',
    },
    stroke: {
        curve: 'smooth'
    },
    fill: {
        type:'solid',
        opacity: [0.35, 1],
    },
    markers: {
        size: 0
    },
    yaxis: [
        {
            title: {
                text: 'Narx korsatikich',
            },
        },
        {
            opposite: true,
            title: {
                text: 'Narx korsatikich',
            },
        },
    ],
    tooltip: {
        shared: true,
        intersect: false,
        y: {
            formatter: function (y) {
                if(typeof y !== "undefined") {
                    return  y.toFixed(0) + " so'm";
                }
                return y;
            }
        }
    }
};

var timeBasedChart = new ApexCharts(document.querySelector("#timeBasedChart"), optionsTimeBased);
timeBasedChart.render();


var timeBasedurl = 'site/timeline-growth';
$.getJSON(timeBasedurl, function(response) {
    timeBasedChart.updateSeries([
      {
            name:'Sotilgan maxsulotlar',
            type: 'area',
            data: response['outsale'],
        }, {
            name: 'Yangi kelgan maxsulotlar',
            type: 'line',
            data: response['incomeGoods']
        }
    ]);
    timeBasedChart.updateOptions({
         labels: response['dates'],
    });

});


/* Nasiyaga olingan maxsulotlar   ===>sana tanlangan paytda   */
$(document).on("click", "#dateButton", function() {
    var nasiyaUrl = 'site/nasiya-products';
    var date = document.getElementById('w1').value;
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        type: 'post',
        url: 'site/nasiya-products',
        data: {date: date, _csrf: csrfToken},
        dataType: 'json',
        success: function (response) {
            console.log(response);
            var t = '';
            for (i = 0; i < response.length; i++) {
                var date = new Date(response[i]['time'] * 1000);
                var formattedTime = date.getDay() + '/' + date.getMonth() + '/' + date.getFullYear() + ' ' + date.getHours() + ' ' + date.getMinutes();
                t +=
                    ' <li class="activity-list">' +
                    ' <div class="activity-icon avatar-xs">' +
                    ' <span class="avatar-title bg-soft-primary text-primary rounded-circle"> <i class="fa fa-user"></i>  </span>' +
                    '</div>' +
                    '<div>' +
                    '<div>' +
                    '  <h5 class="font-size-13">' + response[i]['fullname'] + ' ' + response[i]['nasiya_amount'] + ' so\'mlik nasiyaga maxsulot oldi' + '</h5>' +
                    ' </div>' +
                    '<div>' +
                    '<p class="text-muted mb-0">' + formattedTime + 'da  ' + response[i]['responsible_person'] + ' kafilligi bilan ' + response[i]['deadline'] + ' qaytarish sharti bilan olindi' + '</p>' +
                    '</div>' +
                    '</div>' +
                    '</li>';
            }
            $("#listActivity").empty().append(t);

        },

    });
})


/* sahifa ochilganda */

var nasiyaUrl = 'site/nasiya-products';
var date = document.getElementById('w1').value;
var csrfToken = $('meta[name="csrf-token"]').attr("content");
$.ajax({
    type: 'post',
    url: 'site/nasiya-products',
    data: {date: date, _csrf: csrfToken},
    dataType: 'json',
    success: function (response) {
        console.log(response);
        var t = '';
        for (i = 0; i < response.length; i++) {
            var date = new Date(response[i]['time'] * 1000);
            var formattedTime = date.getDay() + '/' + date.getMonth() + '/' + date.getFullYear() + ' ' + date.getHours() + ' ' + date.getMinutes();
            t +=
                ' <li class="activity-list">' +
                ' <div class="activity-icon avatar-xs">' +
                ' <span class="avatar-title bg-soft-primary text-primary rounded-circle"> <i class="fa fa-user"></i>  </span>' +
                '</div>' +
                '<div>' +
                '<div>' +
                '  <h5 class="font-size-13">' + response[i]['fullname'] + ' ' + response[i]['nasiya_amount'] + ' so\'mlik nasiyaga maxsulot oldi' + '</h5>' +
                ' </div>' +
                '<div>' +
                '<p class="text-muted mb-0">' + formattedTime + 'da  ' + response[i]['responsible_person'] + ' kafilligi bilan ' + response[i]['deadline'] + ' qaytarish sharti bilan olindi' + '</p>' +
                '</div>' +
                '</div>' +
                '</li>';
        }
        $("#listActivity").empty().append(t);
    },
});







