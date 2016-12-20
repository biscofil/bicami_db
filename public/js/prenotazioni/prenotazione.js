$(document).ready(function () {

    _modal = $("#exampleModal");

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


    $("#delete_prenotazione").click(function () {
        bootbox.confirm("Eliminare la prenotazione?", function (result) {
            console.log('This was logged in the callback: ' + result);
            if (result) {
                $.ajax({
                    type: "POST",
                    url: __site_url + "/" + __xhr_controller + "/xhr_elimina_prenotazione",
                    data: {
                        'id_prenotazione': __id_prenotazione
                    }
                }).done(function (data) {
                    if (data.result == 1) {
                        window.location.replace(__site_url + "/" + __prenotazioni_controller);
                    } else {
                        bootbox.alert(data.error);
                    }
                });
            }
        });
    });

    $("#edit_prenotazione").click(function () {
        editing_old_id = $(".selected:first").data('id');
        $.ajax({
            type: "POST",
            cache: false,
            url: __site_url + "/" + __xhr_controller + "/xhr_mia_prenotazione",
            data: {
                'id': __id_prenotazione
            }
        }).done(function (data) {
            if (data.result === 1) {
                _modal.find("#posti").val(data.prenotazione.num_posti_prenotati);

                _modal.find("#id_volo").append('<option value="' + data.prenotazione.id_volo_pianificato + '" selected="selected">' + data.prenotazione.id_volo_pianificato + '</option>');
                _modal.find("#id_volo").trigger('change');

                _modal.find("#classe").val(data.prenotazione.classe).trigger('change');

                _modal.modal('show');
            } else {
                $.notify(data.error, "error");
            }
        });
    });

    $("#btn_update").click(function () {
        if (requiredFieldsCheck()) { 
            //MY_TODO FIX
            bootbox.confirm("Procedere?", function (result) {
                if (result) {
                    $.ajax({
                        type: "POST",
                        cache: false,
                        url: __site_url + "/" + __xhr_controller + "/xhr_modifica_mia_prenotazione",
                        data: {
                            'id': __id_prenotazione,
                            'id_volo': $("#id_volo").val(),
                            'classe': $("#classe").val(),
                            'passeggeri': $("#posti").val()
                        }
                    }).done(function (data) {
                        if (data.result === 1) {
                            _modal.modal('hide');
                            $.notify("Prenotazione modificata", "success");
                            location.reload();
                        } else {
                            $.notify(data.error, "error");
                        }
                    });
                }
            });
        }
    });

});
