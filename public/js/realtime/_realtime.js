var geocoder;
var map;
var bounds;
var markerImage;

function initMap() {
    bounds = new google.maps.LatLngBounds();
    geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 8,
        styles:
                [
                    {
                        stylers: [
                            {
                                visibility: "off"
                            }
                        ]
                    },
                    {
                        featureType: "landscape.natural",
                        elementType: "geometry.fill",
                        stylers: [
                            {
                                color: "#337ab7"
                            },
                            {
                                visibility: "on"
                            }
                        ]
                    },
                    {
                        featureType: "water",
                        elementType: "geometry.fill",
                        stylers: [
                            {
                                color: "#e1e1e1"
                            },
                            {
                                visibility: "on"
                            }
                        ]
                    }
                ]
    });
    var iconBase = __base_url + '/public/img/';

    markerImage = new google.maps.MarkerImage(iconBase + 'Plane.png',
            new google.maps.Size(128, 128),
            new google.maps.Point(0, 0),
            new google.maps.Point(64, 64));
}

function geocode_2(volo) {
    address1 = volo.da_citta + ", " + volo.da_paese;
    address2 = volo.a_citta + ", " + volo.a_paese;

    var d = new Date(volo.data_ora);
    var adesso = new Date().getTime() / 1000;
    var inizio = (d.getTime() / 1000) + (volo.ritardo * 60);
    var fine = inizio + (volo.durata_volo * 60);
    var durata = fine - inizio;
    var passato = adesso - inizio;
    var perc = (passato / durata);

    var posa;
    geocoder.geocode({'address': address1}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            pos = results[0].geometry.location;
            var marker = new google.maps.Marker({
                map: map,
                position: pos,
                icon: iconBase + 'airport_terminal_xs_inv.png'
            });
            posa = pos;
            geocoder.geocode({'address': address2}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    pos = results[0].geometry.location;
                    var marker = new google.maps.Marker({
                        map: map,
                        position: pos,
                        icon: iconBase + 'airport_terminal_xs_inv.png'
                    });
                    var flightPath = new google.maps.Polyline({
                        path: [posa, pos],
                        geodesic: true,
                        strokeColor: '#FF0000',
                        strokeOpacity: 1.0,
                        strokeWeight: 2
                    });
                    bounds.extend(posa);
                    bounds.extend(pos);
                    flightPath.setMap(map);
                    map.fitBounds(bounds);
                    map.panToBounds(bounds);

                    var pos_istantanea = new google.maps.LatLng(
                            posa.lat() + (pos.lat() - posa.lat()) * perc,
                            posa.lng() + (pos.lng() - posa.lng()) * perc);

                    var marker = new google.maps.Marker({
                        map: map,
                        position: pos_istantanea,
                        icon: markerImage
                    });

                } else {
                    console.log('Geocode was not successful for the following reason: ' + status);
                }
            });
        } else {
            console.log('Geocode was not successful for the following reason: ' + status);
        }
    }
    );
}

$(function () {
    $.getJSON(__site_url + "/" + __xhr_controller + "/xhr_realtime", function (data) {
        $.each(data, function (key, volo) {
            geocode_2(volo);
        });
    });
});