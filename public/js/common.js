function requiredFieldsCheck() {
    var ok = true;
    $('form').find('.form-control').each(function () {
        //console.log($(this));
        if ($(this).prop('required')) {
            //console.log("required");
            if (!$(this).val()) {
                var label = $(this).closest('label').text() + "";
                var res = label.replace(/\:/i, "");
                $.notify(res + " NECESSARIO", "error");
                ok = false;
                $(this).closest('.form-group').addClass('has-error');
            } else {
                $(this).closest('.form-group').removeClass('has-error');
            }
        }
    });
    return ok;
}

//

function formatAeroporto(data) {
    if (data.loading)
        return data.text;
    var markup = "<div value='" + data.id + "' class='row'><div class='col-sm-12'>" +
            "<div class='col-sm-2'><img class='img img-responsive' src='http://flagpedia.net/data/flags/small/" + data.code2.toLowerCase() + ".png' /></div>" +
            "<div class='col-sm-10'><div class='row'>" +
            "<div class='col-sm-12'><h4>" + data.name + "</h4></div>" +
            "<div class='col-sm-4'><i class='fa fa-barcode'></i> " + data.id + "</div>" +
            "<div class='col-sm-4'><i class='fa fa-map-marker'></i> " + data.citta + "</div>" +
            "<div class='col-sm-4'><i class='fa fa-globe'></i> " + data.paese + "</div>" +
            "</div></div></div></div>";
    return markup;
}

function formatAeroplano(data) {
    if (data.loading)
        return data.text;
    var markup = "<div value='" + data.id + "' class='row'><div class='col-sm-12'>" +
            "<div class='col-sm-2'><img class='img img-responsive' src='" + __base_url + "/public/img/Plane.png' /></div>" +
            "<div class='col-sm-10'><div class='row'>" +
            "<div class='col-sm-12'><h4>" + data.name + "</h4></div>" +
            "<div class='col-sm-4'><i class='fa fa-barcode'></i> " + data.id + "</div>" +
            "<div class='col-sm-4'>Posti economy: " + data.p_economy + "</div>" +
            "<div class='col-sm-4'>Posti business: " + data.p_business + "</div>" +
            "</div></div></div></div>";
    return markup;
}

function formatCompagnia(data) {
    if (data.loading)
        return data.text;
    var markup = "<div value='" + data.id + "' class='row'><div class='col-sm-12'>" +
            "<div class='col-sm-2'><img class='img img-responsive' src='http://flagpedia.net/data/flags/small/" + data.code2.toLowerCase() + ".png' /></div>" +
            "<div class='col-sm-10'><div class='row'>" +
            "<div class='col-sm-12'><h4>" + data.name + "</h4></div>" +
            "<div class='col-sm-4'><i class='fa fa-barcode'></i> " + data.id + "</div>" +
            "<div class='col-sm-4'><i class='fa fa-globe'></i> " + data.paese + "</div>" +
            "</div></div></div></div>";
    return markup;
}

function formatPaese(data) {
    if (data.loading)
        return data.text;
    var markup = "<div value='" + data.id + "' class='row'><div class='col-sm-12'>" +
            "<div class='col-sm-2'><img class='img img-responsive' src='http://flagpedia.net/data/flags/small/" + data.code2.toLowerCase() + ".png' /></div>" +
            "<div class='col-sm-10'><div class='row'>" +
            "<div class='col-sm-12'><h4>" + data.paese + "</h4></div>" +
            "<div class='col-sm-4'><i class='fa fa-barcode'></i> " + data.id + "</div>" +
            "<div class='col-sm-4'><i class='fa fa-globe'></i> " + data.paese + "</div>" +
            "</div></div></div></div>";
    return markup;
}

function formatCitta(data) {
    if (data.loading)
        return data.text;
    var markup = "<div value='" + data.id + "' class='row'><div class='col-sm-12'>" +
            "<div class='col-sm-2'><img class='img img-responsive' src='http://flagpedia.net/data/flags/small/" + data.code2.toLowerCase() + ".png' /></div>" +
            "<div class='col-sm-10'><div class='row'>" +
            "<div class='col-sm-12'><h4>" + data.citta + "</h4></div>" +
            "<div class='col-sm-4'><i class='fa fa-barcode'></i> " + data.id + "</div>" +
            "<div class='col-sm-4'><i class='fa fa-map-marker'></i> " + data.citta + "</div>" +
            "<div class='col-sm-4'><i class='fa fa-globe'></i> " + data.paese + "</div>" +
            "</div></div></div></div>";
    return markup;
}

function formatTratta(data) {
    if (data.loading)
        return data.text;
    var markup = "<div value='" + data.id + "' class='row'><div class='col-sm-12'>" +
            "<div class='col-sm-2'><img class='img img-responsive' src='" + __base_url + "/public/img/tratta.png' /></div>" +
            "<div class='col-sm-10'><div class='row'>" +
            "<div class='col-sm-12'><h4>" + data.name + "</h4></div>" +
            "<div class='col-sm-4'><i class='fa fa-plane'></i> " + data.cod_compagnia + "</div>" +
            "<div class='col-sm-4'><i class='fa fa-map-marker'></i> " + data.from + "</div>" +
            "<div class='col-sm-4'><i class='fa fa-globe'></i> " + data.to + "</div>" +
            "</div></div></div></div>";
    return markup;
}

function formatVolo(data) {
    // MY_TODO : sistemare gui
    if (data.loading)
        return data.text;
    var markup = "<div value='" + data.id + "' class='row'><div class='col-sm-12'>" +
            "<div class='col-sm-2'><img class='img img-responsive' src='" + __base_url + "/public/img/tratta.png' /></div>" +
            "<div class='col-sm-10'><div class='row'>" +
            "<div class='col-sm-12'><h4>" + data.codice + " ( " + data.data_ora + " )</h4></div>" +
            "<div class='col-sm-4'><i class='fa fa-plane'></i> " + data.nome_compagnia + "</div>" +
            "<div class='col-sm-4'><i class='fa fa-map-marker'></i> " + data.nome_aeroplano + "</div>" +
            "<div class='col-sm-4'><i class='fa fa-globe'></i> " + data.id + "</div>" +
            "</div></div></div></div>";
    return markup;
}

function formatUtente(data) {
    if (data.loading)
        return data.text;
    var markup = "<div value='" + data.id + "' class='row'><div class='col-sm-12'>" +
            "<div class='col-sm-2'><img class='img img-responsive' src='" + __base_url + "/public/img/user_sm.png' /></div>" +
            "<div class='col-sm-10'><div class='row'>" +
            "<div class='col-sm-12'><h4>" + data.nome + " " + data.cognome + "</h4></div>" +
            "<div class='col-sm-4'><i class='fa fa-plane'></i> " + data.username + "</div>" +
            "<div class='col-sm-4'><i class='fa fa-map-marker'></i> " + data.telefono + "</div>" +
            "<div class='col-sm-4'><i class='fa fa-globe'></i> " + data.indirizzo + "</div>" +
            "</div></div></div></div>";
    return markup;
}


$(document).ready(function () {
    $("#dati_demo").click(function () {
        $.notify('Sto inserendo dei dati di prova', "info");
        $.ajax({
            type: "POST",
            cache: false,
            url: __site_url + "/" + __xhr_controller + "/xhr_demo",
            statusCode: {
                404: function () {
                    $.notify("404", "error");
                }
            }
        }).done(function (data) {
            if (data.result === 1) {
                $.notify("Dati inseriti correttamente", "success");
            } else {
                $.notify(data.error, "error");
            }
        }).fail(function () {
            $.notify("ERRORE", "error");
        });
    });
});


