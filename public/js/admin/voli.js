$(document).ready(function () {

    //_admin.js
    adminInit("Nuovo volo", "Modifica volo", "xhr_voli", "xhr_elimina_voli", "Voli eliminati");

    //modal
    $('#data').datetimepicker({
        controlType: 'select',
        oneLine: true,
        timeFormat: 'HH:mm',
        minDate: '+5d',
        dateFormat: 'dd/mm/yy'
    });

    $("#tratta").select2({
        dropdownParent: $("#exampleModal"),
        ajax: {
            url: __site_url + "/" + __xhr_controller + "/xhr_search_tratta",
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
                    o.id = v.codice;
                    o.name = v.codice;
                    o.value = v.codice;
                    o.from = v.aeroporto_partenza;
                    o.to = v.aeroporto_arrivo;
                    o.cod_compagnia = v.cod_compagnia;
                    results.push(o);
                });
                return {
                    results: results
                };
            },
            cache: true
        },
        placeholder: "Seleziona una tratta",
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 2,
        templateResult: formatTratta,
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
                        url: __site_url + "/" + __xhr_controller + "/xhr_nuovo_volo",
                        data: {
                            'tratta': $("#tratta").val(),
                            'data': $("#data").val(),
                            'gate': $("#gate").val(),
                            'ritardo': $("#ritardo").val(),
                            'cancellato': $("#cancellato").prop("checked") ? 1 : 0
                        }
                    }).done(function (data) {
                        if (data.result === 1) {
                            _modal.modal('hide');
                            $.notify("Volo inserito", "success");
                            $("#cancellato").prop("checked", false);
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
                        url: __site_url + "/" + __xhr_controller + "/xhr_modifica_volo",
                        data: {
                            'old_codice': editing_old_id,
                            'tratta': $("#tratta").val(),
                            'data': $("#data").val(),
                            'gate': $("#gate").val(),
                            'ritardo': $("#ritardo").val(),
                            'cancellato': $("#cancellato").prop("checked") ? 1 : 0
                        }
                    }).done(function (data) {
                        if (data.result === 1) {
                            _modal.modal('hide');
                            $.notify("Tratta modificata", "success");
                            $("#cancellato").prop("checked", false);
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
            url: __site_url + "/" + __xhr_controller + "/xhr_volo",
            data: {
                'codice': editing_old_id
            }
        }).done(function (data) {
            if (data.result === 1) {
                _modal.find("#tratta").append('<option value="' + data.volo.codice_volo + '" selected="selected">' + data.volo.codice_volo + '</option>');
                _modal.find("#tratta").trigger('change');

                _modal.find("#gate").val(data.volo.gate);
                _modal.find("#ritardo").val(data.volo.ritardo);
                _modal.find("#cancellato").prop('checked', data.volo.cancellato);
                _modal.find("#data").val(data.volo.data_ora);

                _modal.find('#btn_save').addClass('hidden');
                _modal.find('#btn_update').removeClass('hidden');
                _modal.find('#title_action').text('Modifica');

                _modal.modal('show');
            } else {
                $.notify(data.error, "error");
            }
        });
    });

});
