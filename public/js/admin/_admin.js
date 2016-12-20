//$.fn.select2.defaults.set('language', 'it');

var _modal;
var editing_old_id;
var table;

var __modal_edit_title, __modal_new_title;
var __xhr_delete, __delete_msg;

function adminInit(new_title, edit_title, xhr_datatable, xhr_delete, delete_msg) {
    __modal_edit_title = edit_title;
    __modal_new_title = new_title;
    myDataTableCall(xhr_datatable);
    __xhr_delete = xhr_delete;
    __delete_msg = delete_msg;
}

function myDataTableCall(xhr_method) {
    table = $('#datatable').DataTable({
        language: {
            url: __base_url + 'public/DataTables-1.10.12/Italian.json'
        },
        "bProcessing": true,
        "bServerSide": true,
        "searchDelay": 350,
        "sAjaxSource": __site_url + "/" + __xhr_controller + "/" + xhr_method,
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "fnServerData": function (sSource, aoData, fnCallback) {
            $.getJSON(sSource, aoData, function (json) {
                fnCallback(json);
            });
        },
        "createdRow": function (tr, data, index) {
            $(tr).attr('id', '_' + data[0]);
            $(tr).attr('data-id', data[0]);
        },
        "error": function (xhr, textStatus, error) {
            if (textStatus === 'timeout') {
                $.notify('The server took too long to send the data.', "warning");
            } else {
                $.notify('An error occurred on the server. Please try again in a minute.', "warning");
            }
            table.fnProcessingIndicator(false);
        }
    });
}

function myDeleteCall(xhr_method, msg) {
    var ids = [];
    $(".selected").each(function (index) {
        ids.push($(this).data('id'));
    });
    var len = ids.length;
    bootbox.confirm("Procedere con l'eliminazione di " + (len === 1 ? "un elemento" : len + " elementi") + "?", function (result) {
        if (result) {
            $.ajax({
                type: "POST",
                cache: false,
                url: __site_url + "/" + __xhr_controller + "/" + xhr_method,
                data: {
                    'ids': ids
                },
                statusCode: {
                    404: function () {
                        $.notify("404", "error");
                    }
                }
            }).done(function (data) {
                if (data.result === 1) {
                    table.ajax.reload(null, false);
                    $.notify(msg, "success");
                } else {
                    $.notify(data.error, "error");
                }
            }).fail(function () {
                $.notify("ERRORE", "error");
            });
        }
    });
}

function check_update_delete() {
    var count = $('tr.selected').length;
    $("#btn_delete,.one_plus_item").prop("disabled", count < 1);
    $("#btn_edit,.only_one_item").prop("disabled", count !== 1);
}

function clear_selection() {
    $('tr.selected').removeClass('selected');
    check_update_delete();
}



$(document).ready(function () {

    _modal = $("#exampleModal");

    $("#btn_delete").click(function () {
        myDeleteCall(__xhr_delete, __delete_msg);
    });

    $("#btn_edit").click(function () {
        _modal.find('#btn_save').addClass('hidden');
        _modal.find('#btn_update').removeClass('hidden');

        _modal.find('#exampleModalLabel').text(__modal_edit_title);

        $('.form-group').removeClass('has-error');
    });

    $("#btn_new").click(function () {
        _modal.modal('show');

        _modal.find('#btn_update').addClass('hidden');
        _modal.find('#btn_save').removeClass('hidden');

        _modal.find('#exampleModalLabel').text(__modal_new_title);

        _modal.find('.form-group').removeClass('has-error');
        _modal.find('.form-control').val('').trigger("change").prop("checked", false);
    });

    //--------------

    $('#datatable').on('page', function () {
        clear_selection();
    });

    $('#datatable').on('search.dt', function () {
        clear_selection();
    });

    $('#datatable').on('order.dt', function () {
        clear_selection();
    });

    $('#datatable').on('draw.dt', function () {
        check_update_delete();
    });

    $('#datatable').on("click", "tr", function () {
        $(this).toggleClass('selected');
        check_update_delete();
    });
});

