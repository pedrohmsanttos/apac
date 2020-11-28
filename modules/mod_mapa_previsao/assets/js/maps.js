function supports_html5_storage() {
    try {
        return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
        return false;
    }
}


var coords;
var map;
window.mapMarkers = new Array();

function init() {
    navigator.geolocation.getCurrentPosition(function(position) {
            coords = position.coords;
            console.log(coords);
            window.L = L;
            window.map = L.map('map').setView([position.coords.latitude, position.coords.longitude ], 20);
            console.log("map" + window.map);
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors', maxZoom: 18 }).addTo(window.map);

            L.marker([-8.0635147, -34.8730271]).addTo(map).bindPopup('A pretty CSS3 popup.<br> Easily customizable.').openPopup();

            noLoc = false;
        }
        , function(err) {
            if (err.code == 2) {
                alert("Position unavailable.");
            } else if (err.code = 3) {
                alert("Timeout expired.");
            } else {
                console.log(err.code);
                console.log(err.message);
            }
        }, {timeout: 10000, enableHighAccuracy: false, maximumAge: 75000}

    );
}

function init3(){

    window.L = L;
    window.map = L.map('map').setView([-8.0633637, -34.8733352], 10);
    console.log("map" + window.map);
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors - by <a href="http://www.inhalt.com.br">Inhalt</a>', maxZoom: 18 }).addTo(window.map);
    //L.marker([-8.0635147, -34.8730271]).addTo(map)
    var markers = {};

    /*map.createPane('labels');
    map.getPane('labels').style.zIndex = 650;

    map.getPane('labels').style.pointerEvents = 'none';

    var positron = L.tileLayer('http://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png', {
        attribution: '©OpenStreetMap, ©CartoDB'
    }).addTo(map);

    var positronLabels = L.tileLayer('http://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}.png', {
            attribution: '©OpenStreetMap, ©CartoDB',
            pane: 'labels'
    }).addTo(map);

    var geojson = L.geoJson(GeoJsonData, geoJsonOptions).addTo(map);

        /*var myLayer = L.geoJSON().addTo(map);
        myLayer.addData(geojsonFeature);*/

    // L.geoJSON(geojsonFeature).addTo(map);
    window.map.on('click', onClickMap);

    noLoc = false;

}

function init2() {
    window.coords = null;
    if ( navigator.geolocation ) {
        navigator.geolocation.watchPosition(
            function ( Position ) {
                window.coords = Position.coords;
                coords = window.coords;
                console.log(coords);
                window.L = L;
                window.map = L.map('map').setView([Position.coords.latitude, Position.coords.longitude ], 10);
                //window.map = L.map('map').setView([-8.1157, -34.8945 ], 25);
                console.log("map" + window.map);
                L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors - by <a href="http://www.inhalt.com.br">Inhalt</a>', maxZoom: 18 }).addTo(window.map);
                
                var markers = {};


                window.map.on('click', onClickMap);

                noLoc = false;
            },
            function (err) {
                // there was an error getting the location
                alert(err.message);
            },
            {enableHighAccuracy:false, maximumAge:100000, timeout:100000}
        );
    }}


function onClick(e) {
    
    // alert(this.getLatLng());
    console.log($(this)  );
    $(".mapa_praia").addClass('map_normal');
    $(".mais_informacoes").hide();
    $(".detalhes_praia").hide();
    $(".sobre_praias").show();
    $(".sobre_praias").addClass('fadeInUp');

    // var el = $(e.srcElement || e.target),
    //    id = el.attr('id');

    // alert('Here is the markers ID: ' + id + '. Use it as you wish.')
    
}

function onClickMap (e){
    $(".mapa_praia").removeClass('map_normal');
    $(".mapa_praia").removeClass('map_total_info');
    $(".sobre_praias").hide();
    $(".mais_informacoes").show();
    $(".detalhes_praia").hide();
    $(".sobre_praias").addClass('fadeInUp');
}