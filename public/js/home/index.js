$(document).ready(function () {

    $("#data").datepicker({
        minDate: 0,
        dateFormat: 'dd/mm/yy'
    });

    $("#classe").select2();

    $("#aeroporto_da , #aeroporto_a").select2({
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
        templateSelection: function (people) {
            return people.name || people.text;
        }
    });

    $(".tratta-preferita").click(function () {
        var me = $(this);
        $("#aeroporto_da").append('<option value="' + me.data('from') + '" selected="selected">' + me.data('name_from') + '</option>');
        $("#aeroporto_da").trigger('change');

        $("#aeroporto_a").append('<option value="' + me.data('to') + '" selected="selected">' + me.data('name_to') + '</option>');
        $("#aeroporto_a").trigger('change');
    });


    $("#my_form_submit").click(function (event) {

        var _ok = true;

        //controlli

        if ($("#aeroporto_da").val() == $("#aeroporto_a").val()) {
            _ok = false;
            $.notify("Scegliere due aeroporti diversi", "error");
        }

        if (!_ok) {
            event.preventDefault();
        }

    });


});