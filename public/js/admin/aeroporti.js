$(document).ready(function () {

    //_admin.js
    adminInit("Nuovo aeroporto", "Modifica aeroporto", "xhr_aeroporti", "xhr_elimina_aeroporti", "Aeroporti eliminati");

    //modal
    $("#citta").select2({
        dropdownParent: $("#exampleModal"),
        ajax: {
            url: __site_url + "/" + __xhr_controller + "/xhr_search_citta",
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
                    o.id = v.id_citta;
                    o.citta = v.nome_citta;
                    o.id_paese = v.id_paese;
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
        placeholder: "Seleziona una citta",
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 2,
        templateResult: formatCitta,
        templateSelection: function (citta) {
            return citta.citta || citta.text;
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
                        url: __site_url + "/" + __xhr_controller + "/xhr_nuovo_aeroporto",
                        data: {
                            'sigla': $("#sigla").val(),
                            'nome': $("#nome").val(),
                            'id_citta': $("#citta").val()
                        }
                    }).done(function (data) {
                        if (data.result === 1) {
                            _modal.modal('hide');
                            $.notify("Aeroporto inserito", "success");
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
                        url: __site_url + "/" + __xhr_controller + "/xhr_modifica_aeroporto",
                        data: {
                            'old_sigla': editing_old_id,
                            'sigla': $("#sigla").val(),
                            'nome': $("#nome").val(),
                            'id_citta': $("#citta").val()
                        }
                    }).done(function (data) {
                        if (data.result === 1) {
                            _modal.modal('hide');
                            $.notify("Aeroporto modificato", "success");
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
            url: __site_url + "/" + __xhr_controller + "/xhr_aeroporto",
            data: {
                'sigla': editing_old_id
            }
        }).done(function (data) {
            if (data.result === 1) {
                _modal.find("#sigla").val(data.aeroporto.sigla);
                _modal.find("#nome").val(data.aeroporto.nome);

                _modal.find("#citta").append('<option value="' + data.aeroporto.id_citta + '" selected="selected">' + data.aeroporto.nome_citta + '</option>');
                _modal.find("#citta").trigger('change');
                
                _modal.modal('show');
            } else {
                $.notify(data.error, "error");
            }
        });
    });

});
