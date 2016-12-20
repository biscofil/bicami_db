$(document).ready(function () {

    //_admin.js
    adminInit("Nuova compagnia", "Modifica compagnia", "xhr_compagnie", "xhr_elimina_compagnie", "Compagnie eliminate");

    //modal
    $("#id_paese").select2({
        dropdownParent: $("#exampleModal"),
        ajax: {
            url: __site_url + "/" + __xhr_controller + "/xhr_search_paese",
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
                    o.id = v.code;
                    o.paese = v.name;
                    o.code2 = v.code2;
                    results.push(o);
                });
                return {
                    results: results
                };
            },
            cache: true
        },
        placeholder: "Seleziona un paese",
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 2,
        templateResult: formatPaese,
        templateSelection: function (paese) {
            return paese.paese || paese.text;
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
                        url: __site_url + "/" + __xhr_controller + "/xhr_nuova_compagnia",
                        data: {
                            'nome': $("#nome").val(),
                            'id_paese': $("#id_paese").val()
                        }
                    }).done(function (data) {
                        if (data.result === 1) {
                            _modal.modal('hide');
                            $.notify("Compagnia inserita", "success");
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
                        url: __site_url + "/" + __xhr_controller + "/xhr_modifica_compagnia",
                        data: {
                            'id': editing_old_id,
                            'nome': $("#nome").val(),
                            'id_paese': $("#id_paese").val()
                        }
                    }).done(function (data) {
                        if (data.result === 1) {
                            _modal.modal('hide');
                            $.notify("Compagnia modificata", "success");
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
            url: __site_url + "/" + __xhr_controller + "/xhr_compagnia",
            data: {
                'id': editing_old_id
            }
        }).done(function (data) {
            if (data.result === 1) {
                _modal = $("#exampleModal").modal('show');

                _modal.find("#nome").val(data.compagnia.nome);

                _modal.find("#id_paese").append('<option value="' + data.compagnia.nazionalita + '" selected="selected">' + data.compagnia.nazionalita + '</option>');
                _modal.find("#id_paese").trigger('change');

                _modal.modal('show');
            } else {
                $.notify(data.error, "error");
            }
        });
    });
});