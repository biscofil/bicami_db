var ratio = 0.5;

var atom_len = 4;

var header_str = " CODE FROM DEST GATE DELA ";

function myformat(mystr) {
    mystr = "" + mystr;
    if (mystr.length > atom_len) {
        return mystr.substring(0, atom_len);
    } else {
        return ('    ' + mystr).slice(-atom_len);
    }
}

function row_format(myobj) {
    return ' ' + myformat(myobj.codice_volo) + ' ' + myformat(myobj.aeroporto_partenza) + ' ' + myformat(myobj.aeroporto_arrivo) + ' ' + myformat(myobj.gate) + ' ' + myformat(myobj.ritardo) + ' ';
}

function refresh_tabellone() {
    $.getJSON(__site_url + "/" + __xhr_controller + "/xhr_tabellone", function (data) {
        for (var i = 0; i < 5; i++) {
            var s = "";
            if (i in data) {
                s = row_format(data[i]);
            } else {
                s = "--"; //Array(header_str.lenght).join(" ");
            }
            $("#splitflap_" + i).splitFlap({
                text: s,
                charWidth: 50 * ratio,
                charHeight: 100 * ratio,
                imageSize: (2500 * ratio) + 'px ' + (100 * ratio) + 'px',
                speed: 15,
                speedVariation: 3,
                image: __base_url + '/public/splitflap/images/chars.png'
            });
            //console.log($("#splitflap_" + i).splitFlap('splitflap').setText("q2e2"));
        }
    });
}

(function ($) {
    $(document).ready(function () {
        $(".header-splitflap")
                .splitFlap({
                    text: header_str,
                    charWidth: 50 * ratio,
                    charHeight: 100 * ratio,
                    imageSize: (2500 * ratio) + 'px ' + (100 * ratio) + 'px',
                    speed: 15,
                    speedVariation: 3,
                    image: __base_url + '/public/splitflap/images/chars.png'
                });

        $('.empty-splitflap')
                .splitFlap({
                    text: Array(header_str.lenght).join(" "),
                    charWidth: 50 * ratio,
                    charHeight: 100 * ratio,
                    imageSize: (2500 * ratio) + 'px ' + (100 * ratio) + 'px',
                    speed: 15,
                    speedVariation: 3,
                    image: __base_url + '/public/splitflap/images/chars.png'
                });

        setInterval(
                function () {
                    refresh_tabellone();
                },
                10000
                );

        refresh_tabellone();
    });

})(jQuery);