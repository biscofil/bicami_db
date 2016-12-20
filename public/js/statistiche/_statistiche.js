$(function () {

    var data = [];

    for (var i = 0; i < __stat_partenzeTotaliAeroporti.length; i++) {
        data[i] = {
            label: __stat_partenzeTotaliAeroporti[i][2],
            data: __stat_partenzeTotaliAeroporti[i][1]
        };
    }

    $.plot("#placeholder", data, {
        series: {
            pie: {
                innerRadius: 0.5,
                show: true
            }
        }
    });

//

    var data2 = [];

    for (var i = 0; i < __stat_arriviArriviAeroporti.length; i++) {
        data2[i] = {
            label: __stat_arriviArriviAeroporti[i][2],
            data: __stat_arriviArriviAeroporti[i][1]
        };
    }

    $.plot("#placeholder2", data2, {
        series: {
            pie: {
                innerRadius: 0.5,
                show: true
            }
        }
    });
//

    var data3 = [];

    for (var i = 0; i < __stat_passeggeriTrasportatiAeroporto.length; i++) {
        data3[i] = {
            label: __stat_passeggeriTrasportatiAeroporto[i][2],
            data: __stat_passeggeriTrasportatiAeroporto[i][1]
        };
    }

    $.plot("#placeholder3", data3, {
        series: {
            pie: {
                innerRadius: 0.5,
                show: true
            }
        }
    });

});