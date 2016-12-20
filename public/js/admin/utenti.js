$(document).ready(function () {

    //_admin.js
    adminInit("Nuovo utente", "Modifica utente", "xhr_utenti", "xhr_elimina_utenti", "Utenti eliminati");

    //modal btns

    $("#btn_save").click(function () {
        if ($("#password").val() === $("#password_confirm").val()) {
            if (requiredFieldsCheck()) {
                bootbox.confirm("Procedere?", function (result) {
                    if (result) {
                        $.ajax({
                            type: "POST",
                            cache: false,
                            url: __site_url + "/" + __xhr_controller + "/xhr_nuovo_utente",
                            data: {
                                'nome': $("#nome").val(),
                                'cognome': $("#cognome").val(),
                                'telefono': $("#telefono").val(),
                                'indirizzo': $("#indirizzo").val(),
                                'carta_credito': $("#carta_credito").val(),
                                'user_level': $("#admin").prop("checked") ? 1 : 0,
                                'username': $("#username").val(),
                                'password': $("#password").val()
                            }
                        }).done(function (data) {
                            if (data.result === 1) {
                                _modal.modal('hide');
                                $.notify("Utente inserito", "success");
                                table.ajax.reload(null, false);
                            } else {
                                $.notify(data.error, "error");
                            }
                        });
                    }
                });
            }
        } else {
            $.notify("Le password non combaciano", "error");
        }
    });

    function do_update() {
        bootbox.confirm("Procedere?", function (result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: __site_url + "/" + __xhr_controller + "/xhr_modifica_utente",
                    data: {
                        'id': editing_old_id,
                        'nome': $("#nome").val(),
                        'cognome': $("#cognome").val(),
                        'telefono': $("#telefono").val(),
                        'indirizzo': $("#indirizzo").val(),
                        'carta_credito': $("#carta_credito").val(),
                        'user_level': $("#admin").prop("checked") ? 1 : 0,
                        'username': $("#username").val(),
                        'password': $("#password").val()
                    }
                }).done(function (data) {
                    if (data.result === 1) {
                        _modal.modal('hide');
                        $.notify("Utente modificato", "success");
                        table.ajax.reload(null, false);
                    } else {
                        $.notify(data.error, "error");
                    }
                });
            }
        });
    }

    $("#btn_update").click(function () {
        if ($("#password").val() || $("#password_confirm").val()) {
            if ($("#password").val() === $("#password_confirm").val()) {
                if (requiredFieldsCheck()) {
                    $.notify("Modifico anche la password", "info");
                    do_update();
                }
            } else {
                $.notify("Le password non combaciano", "error");
            }
        } else {
            $.notify("Modifico lasciando la password invariata", "info");
            do_update();
        }
    });

    //actions

    $("#btn_new").click(function () {
        _modal.find("#password").prop('required', true);
        _modal.find("#password_confirm").prop('required', true);

        _modal.find("#password").attr('placeholder', "Password");
        _modal.find("#password_confirm").attr('placeholder', "Conferma password");

    });

    $("#btn_edit").click(function () {

        _modal.find("#password").prop('required', false);
        _modal.find("#password_confirm").prop('required', false);

        _modal.find("#password").attr('placeholder', "Lasciare vuoto per lasciare la password invariata");
        _modal.find("#password_confirm").attr('placeholder', "Lasciare vuoto per lasciare la password invariata");

        editing_old_id = $(".selected:first").data('id');
        $.ajax({
            type: "POST",
            cache: false,
            url: __site_url + "/" + __xhr_controller + "/xhr_utente",
            data: {
                'id': editing_old_id
            }
        }).done(function (data) {
            if (data.result === 1) {
                _modal.find("#nome").val(data.utente.nome);
                _modal.find("#cognome").val(data.utente.cognome);
                _modal.find("#telefono").val(data.utente.telefono);
                _modal.find("#indirizzo").val(data.utente.indirizzo);
                _modal.find("#carta_credito").val(data.utente.carta_credito);
                _modal.find("#admin").prop('checked', data.utente.user_level == 1);
                _modal.find("#username").val(data.utente.username);
                _modal.find("#password, #password_confirm").val("");
                _modal.modal('show');
            } else {
                $.notify(data.error, "error");
            }
        });
    });

});
