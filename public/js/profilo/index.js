$(document).ready(function () {

    function do_update() {
        bootbox.confirm("Procedere?", function (result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: __site_url + "/" + __xhr_controller + "/xhr_modifica_profilo",
                    data: {
                        'nome': $("#nome").val(),
                        'cognome': $("#cognome").val(),
                        'telefono': $("#telefono").val(),
                        'indirizzo': $("#indirizzo").val(),
                        'carta_credito': $("#carta_credito").val(),
                        'username': $("#username").val(),
                        'password': $("#password").val()
                    }
                }).done(function (data) {
                    if (data.result === 1) {
                        //$.notify("Utente modificato", "success");
                        location.reload();
                    } else {
                        $.notify(data.error, "error");
                    }
                });
            }
        });
    }

    $("#btn-save").click(function () {
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

    $("#btn-cancel").click(function () {
        location.reload();
    });
});
