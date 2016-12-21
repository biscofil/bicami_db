$(document).ready(function () {

    //_admin.js
    adminInit("Nuova prenotazione", "Modifica prenotazione", "xhr_prenotazioni", "xhr_elimina_prenotazioni", "Prenotazioni eliminate");

    //modal
    $("#id_volo").select2({
        dropdownParent: $("#exampleModal"),
        ajax: {
            url: __site_url + "/" + __xhr_controller + "/xhr_search_volo",
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
                    o.codice = v.codice;
                    o.data_ora = v.data_ora;
                    o.nome_aeroplano = v.nome_aeroplano;
                    o.nome_compagnia = v.nome_compagnia;
                    results.push(o);
                });
                return {
                    results: results
                };
            },
            cache: true
        },
        placeholder: "Seleziona un volo",
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 2,
        templateResult: formatVolo,
        templateSelection: function (data) {
            return data.codice || data.text;
        }
    });

    $("#classe").select2();

    $("#id_utente").select2({
        dropdownParent: $("#exampleModal"),
        ajax: {
            url: __site_url + "/" + __xhr_controller + "/xhr_search_utente",
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
                    o.nome = v.nome;
                    o.cognome = v.cognome;
                    o.indirizzo = v.indirizzo;
                    o.telefono = v.telefono;
                    o.username = v.username;
                    results.push(o);
                });
                return {
                    results: results
                };
            },
            cache: true
        },
        placeholder: "Seleziona un utente",
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 2,
        templateResult: formatUtente,
        templateSelection: function (data) {
            return data.nome ? (data.nome + " " + data.cognome) : data.text;
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
                        url: __site_url + "/" + __xhr_controller + "/xhr_prenota",
                        data: {
                            'id_volo': $("#id_volo").val(),
                            'id_utente': $("#id_utente").val(),
                            'classe': $("#classe").val(),
                            'passeggeri': $("#posti").val()
                        }
                    }).done(function (data) {
                        if (data.result === 1) {
                            _modal.modal('hide');
                            $.notify("Prenotazione effettuata", "success");
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
                        url: __site_url + "/" + __xhr_controller + "/xhr_modifica_prenotazione",
                        data: {
                            'id': editing_old_id,
                            'id_volo': $("#id_volo").val(),
                            'id_utente': $("#id_utente").val(),
                            'classe': $("#classe").val(),
                            'passeggeri': $("#posti").val()
                        }
                    }).done(function (data) {
                        if (data.result === 1) {
                            _modal.modal('hide');
                            $.notify("Prenotazione modificata", "success");
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
            url: __site_url + "/" + __xhr_controller + "/xhr_prenotazione",
            data: {
                'id': editing_old_id
            }
        }).done(function (data) {
            if (data.result === 1) {


                $.ajax({
                    type: "POST",
                    cache: false,
                    url: __site_url + "/" + __xhr_controller + "/xhr_utente",
                    data: {
                        'id': data.prenotazione.id_utente
                    }
                }).done(function (data2) {

                    _modal.find("#posti").val(data.prenotazione.num_posti_prenotati);

                    _modal.find("#id_utente").append('<option value="' + data.prenotazione.id_utente + '" selected="selected">' + data2.utente.nome + " " + data2.utente.cognome + '</option>');
                    _modal.find("#id_utente").trigger('change');

                    _modal.find("#id_volo").append('<option value="' + data.prenotazione.id_volo_pianificato + '" selected="selected">' + data.prenotazione.id_volo_pianificato + '</option>');
                    _modal.find("#id_volo").trigger('change');

                    _modal.find("#classe").val(data.prenotazione.classe).trigger('change');

                    _modal.modal('show');
                });

            } else {
                $.notify(data.error, "error");
            }
        });
    });
});
