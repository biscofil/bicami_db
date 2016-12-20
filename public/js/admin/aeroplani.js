$(document).ready(function () {

    //_admin.js
    adminInit("Nuovo aeroplano", "Modifica aeroplano", "xhr_aeroplani", "xhr_elimina_aeroplani", "Aeroplani eliminati");

    //modal btns
    $("#btn_save").click(function () {
        if (requiredFieldsCheck()) {
            bootbox.confirm("Procedere?", function (result) {
                if (result) {
                    $.ajax({
                        type: "POST",
                        cache: false,
                        url: __site_url + "/" + __xhr_controller + "/xhr_nuovo_aeroplano",
                        data: {
                            'nome': $("#nome").val(),
                            'posti_economy': $("#posti_economy").val(),
                            'posti_business': $("#posti_business").val()
                        }
                    }).done(function (data) {
                        if (data.result === 1) {
                            _modal.modal('hide');
                            $.notify("Aeroplano inserito", "success");
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
                        url: __site_url + "/" + __xhr_controller + "/xhr_modifica_aeroplano",
                        data: {
                            'id': editing_old_id,
                            'nome': $("#nome").val(),
                            'posti_economy': $("#posti_economy").val(),
                            'posti_business': $("#posti_business").val()
                        }
                    }).done(function (data) {
                        if (data.result === 1) {
                            _modal.modal('hide');
                            $.notify("Aeroplano modificato", "success");
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
            url: __site_url + "/" + __xhr_controller + "/xhr_aeroplano",
            data: {
                'id': editing_old_id
            }
        }).done(function (data) {
            if (data.result === 1) {
                _modal.find("#nome").val(data.aeroplano.nome);
                _modal.find("#posti_economy").val(data.aeroplano.posti_economy);
                _modal.find("#posti_business").val(data.aeroplano.posti_business);

                _modal.modal('show');
            } else {
                $.notify(data.error, "error");
            }
        });
    });
});
