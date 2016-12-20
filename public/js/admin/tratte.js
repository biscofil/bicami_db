$(document).ready(function () {

    //_admin.js
    adminInit("Nuova tratta", "Modifica tratta", "xhr_tratte", "xhr_elimina_tratte", "Tratte eliminate");

    //modal
    $("#a_partenza,#a_arrivo").select2({
        dropdownParent: $("#exampleModal"),
        ajax: {
            url: __site_url + "/" + __xhr_controller + "/xhr_search_aeroporto",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data, page) {
                var results = [];
                $.each(data, function (i, v) {
                    var o = {};
                    o.id = v.sigla;
                    o.name = v.nome;
                    o.value = v.sigla;
                    o.citta = v.nome_citta;
                    o.paese = v.nome_paese;
                    o.code2 = v.code2;
                    results.push(o);
                });
                return {
                    results: results
                };
            },
            cache: true
        },
        placeholder: "Seleziona un aeroporto",
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 2,
        templateResult: formatAeroporto,
        templateSelection: function (data) {
            return data.name || data.text;
        }
    });

    $("#compagnia").select2({
        dropdownParent: $("#exampleModal"),
        ajax: {
            url: __site_url + "/" + __xhr_controller + "/xhr_search_compagnia",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data, page) {
                var results = [];
                $.each(data, function (i, v) {
                    var o = {};
                    o.id = v.id;
                    o.name = v.nome;
                    o.value = v.id;
                    o.paese = v.paese;
                    o.code2 = v.code2;
                    results.push(o);
                });
                return {
                    results: results
                };
            },
            cache: true
        },
        placeholder: "Seleziona una compagnia",
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 2,
        templateResult: formatCompagnia,
        templateSelection: function (data) {
            return data.name || data.text;
        }
    });

    $("#aeroplano").select2({
        dropdownParent: $("#exampleModal"),
        ajax: {
            url: __site_url + "/" + __xhr_controller + "/xhr_search_aeroplano",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data, page) {
                var results = [];
                $.each(data, function (i, v) {
                    var o = {};
                    o.id = v.id;
                    o.name = v.nome;
                    o.p_economy = v.posti_economy;
                    o.p_business = v.posti_business;
                    results.push(o);
                });
                return {
                    results: results
                };
            },
            cache: true
        },
        placeholder: "Seleziona un aeroplano",
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 2,
        templateResult: formatAeroplano,
        templateSelection: function (data) {
            return data.name || data.text;
        }
    });

    //modal btns

    $("#btn_save").click(function () {
        if (requiredFieldsCheck()) {
            bootbox.confirm("Procedere?", function (result) {
                if (result) {
                    $.ajax({
                        type: "POST",
                        cache: false,
                        url: __site_url + "/" + __xhr_controller + "/xhr_nuova_tratta",
                        data: {
                            'codice': $("#codice").val(),
                            'compagnia': $("#compagnia").val(),
                            'a_partenza': $("#a_partenza").val(),
                            'a_arrivo': $("#a_arrivo").val(),
                            'durata': $("#durata").val(),
                            'p_economy': $("#p_economy").val(),
                            'p_business': $("#p_business").val(),
                            'aeroplano': $("#aeroplano").val()
                        }
                    }).done(function (data) {
                        if (data.result === 1) {
                            _modal.modal('hide');
                            $.notify("Tratta inserita", "success");
                            table.ajax.reload(null, false);
                        } else {
                            $.notify(data.error, "error");
                        }
                    });
                }
            });
        }
    });

    $("#btn_update").click(function () {
        if (requiredFieldsCheck()) {
            bootbox.confirm("Procedere?", function (result) {
                if (result) {
                    $.ajax({
                        type: "POST",
                        cache: false,
                        url: __site_url + "/" + __xhr_controller + "/xhr_modifica_tratta",
                        data: {
                            'old_codice': editing_old_id,
                            'codice': $("#codice").val(),
                            'compagnia': $("#compagnia").val(),
                            'a_partenza': $("#a_partenza").val(),
                            'a_arrivo': $("#a_arrivo").val(),
                            'durata': $("#durata").val(),
                            'p_economy': $("#p_economy").val(),
                            'p_business': $("#p_business").val(),
                            'aeroplano': $("#aeroplano").val()
                        }
                    }).done(function (data) {
                        if (data.result === 1) {
                            _modal.modal('hide');
                            $.notify("Tratta modificata", "success");
                            table.ajax.reload(null, false);
                        } else {
                            $.notify(data.error, "error");
                        }
                    });
                }
            });
        }
    });

    //actions

    $("#btn_edit").click(function () {
        editing_old_id = $(".selected:first").data('id');
        $.ajax({
            type: "POST",
            cache: false,
            url: __site_url + "/" + __xhr_controller + "/xhr_tratta",
            data: {
                'codice': editing_old_id
            }
        }).done(function (data) {
            if (data.result === 1) {
                _modal.find("#codice").val(data.tratta.codice);

                _modal.find("#compagnia").append('<option value="' + data.tratta.cod_compagnia + '" selected="selected">' + data.tratta.nome_compagnia + '</option>');
                _modal.find("#compagnia").trigger('change');

                _modal.find("#a_partenza").append('<option value="' + data.tratta.aeroporto_partenza + '" selected="selected">' + data.tratta.aeroporto_partenza + '</option>');
                _modal.find("#a_partenza").trigger('change');

                _modal.find("#a_arrivo").append('<option value="' + data.tratta.aeroporto_arrivo + '" selected="selected">' + data.tratta.aeroporto_arrivo + '</option>');
                _modal.find("#a_arrivo").trigger('change');

                _modal.find("#durata").val(data.tratta.durata_volo);
                _modal.find("#p_economy").val(data.tratta.prezzo_economy);
                _modal.find("#p_business").val(data.tratta.prezzo_business);

                $("#aeroplano").append('<option value="' + data.tratta.tipo_aeroplano + '" selected="selected">' + data.tratta.nome_aeroplano + '</option>');
                $("#aeroplano").trigger('change');

                _modal.modal('show');
            } else {
                $.notify(data.error, "error");
            }
        });
    });

});