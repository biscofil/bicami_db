$(document).ready(function () {
    $(".btn-prenotazione").click(function () {
        var me = $(this);
        $(".btn-prenotazione").addClass('disabled');
        $.ajax({
            type: "POST",
            url: __site_url + "/" + __xhr_controller + "/xhr_prenota",
            data: {
                'id_volo': __id_volo,
                'id_utente': __id_utente,
                'classe': me.data('classe'),
                'passeggeri': __passeggeri
            }
        }).done(function (data) {
            var id_prenotazione = data.id_prenotazione;
            if (data.result == 1) {
                window.location.replace(__site_url + "/" + __prenotazioni_controller + "/" + __prenotazioni_method + "/" + id_prenotazione);
            }
        });
    });
});


