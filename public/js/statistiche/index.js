var d4 = [];

for (var i = 0; i < __stat_arrivi_partenze_aeroporti.length; i++) {
    d4.push({aeroporto: __stat_arrivi_partenze_aeroporti[i][1], p: __stat_arrivi_partenze_aeroporti[i][2], a: __stat_arrivi_partenze_aeroporti[i][3]});
}

Morris.Bar({
    element: 'graph4',
    data: d4,
    xkey: 'aeroporto',
    ykeys: ['p', 'a'],
    labels: ['Partiti', 'Arrivati']
});

//

var d5 = [];

for (var i = 0; i < __stat_tratte_prenotazioni.length; i++) {
    d5.push({tratta: __stat_tratte_prenotazioni[i][0], p: __stat_tratte_prenotazioni[i][1]});
}

Morris.Bar({
    element: 'graph5',
    data: d5,
    xkey: 'tratta',
    ykeys: ['p'],
    labels: ['Prenotazioni']
});

//

var d6 = [];

for (var i = 0; i < __stat_tratte_voli.length; i++) {
    d6.push({tratta: __stat_tratte_voli[i][0], v: __stat_tratte_voli[i][1]});
}

Morris.Bar({
    element: 'graph6',
    data: d6,
    xkey: 'tratta',
    ykeys: ['v'],
    labels: ['voli']
});