var geocoder;
var map;
var bounds;

function initMap() {
    bounds = new google.maps.LatLngBounds();
    geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
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
    codeAddress(__from, __to);
}

function codeAddress(address1, address2) {
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
            bounds.extend(pos);
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
                        path: [posa, posb],
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

                } else {
                    console.log('Geocode was not successful for the following reason: ' + status);
                }
            });

        } else {
            console.log('Geocode was not successful for the following reason: ' + status);
        }
    });
}
// Disable Google Maps scrolling
// See http://stackoverflow.com/a/25904582/1607849
// Disable scroll zooming and bind back the click event
var onMapMouseleaveHandler = function (event) {
    var that = $(this);
    that.on('click', onMapClickHandler);
    that.off('mouseleave', onMapMouseleaveHandler);
    that.find('#map').css("pointer-events", "none");
};
var onMapClickHandler = function (event) {
    var that = $(this);
    // Disable the click handler until the user leaves the map area
    that.off('click', onMapClickHandler);
    // Enable scrolling zoom
    that.find('#map').css("pointer-events", "auto");
    // Handle the mouse leave event
    that.on('mouseleave', onMapMouseleaveHandler);
};

$(document).ready(function () {
    // Enable map zooming with mouse scroll when the user clicks the map
    $('.map').on('click', onMapClickHandler);
});

