
<?php
use yii\web\JsExpression;
use yii\helpers\Json;

use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\plugins\geocoder\ServiceNominatim;
use dosamigos\leaflet\plugins\geocoder\GeoCoder;



?>

<?php


    // lets use nominating service
    $nominatim = new ServiceNominatim();

    // create geocoder plugin and attach the service
    $geoCoderPlugin = new GeoCoder([
        'service' => $nominatim,
        'clientOptions' => [
            'showMarker' => false
        ]
    ]);

    // add a marker to center
    $center = new LatLng(['lat' => -26.117, 'lng' => 137.133]);
    if($model->lat!=null&&$model->lng!=null)
        $center = new LatLng(['lat' => $model->lat, 'lng' => $model->lng]);
    $marker = new Marker([
        'name' => 'geoMarker',
        'latLng' => $center,
        'clientOptions' => ['draggable' => true], // draggable marker
        'clientEvents' => [
            'dragend' => 'function(e){
                document.getElementById("interview-lat").value=e.target._latlng.lat;
                document.getElementById("interview-lng").value=e.target._latlng.lng;
                saved=false;
                console.log(e.target._latlng.lat, e.target._latlng.lng);
            }'
        ]
    ]);

    // configure the tile layer
    $tileLayer = new TileLayer([
        'urlTemplate' => 'https://a.tile.openstreetmap.org/{z}/{x}/{y}.png',
        'clientOptions' => [
            'attribution' => 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
            'subdomains' => '1234'
        ]
    ]);


    // initialize our leafLet component
    $leaflet = new LeafLet([
        'name' => 'geoMap',
        'tileLayer' => $tileLayer,
        'center' => $center,
        'zoom' => 4,
        'clientEvents' => [
            // I added an event to ease the collection of new position
            'geocoder_showresult' => 'function(e){
                // set markers position
                geoMarker.setLatLng(e.Result.center);
                document.getElementById("interview-intervieweelocation").value=e.Result.name;
                document.getElementById("interview-lat").value=e.Result.center.lat;
                document.getElementById("interview-lng").value=e.Result.center.lng;
                saved=false;
                //alert(JSON.stringify(e.Result));
                //alert(e.Result.center);
                //alert(e.Result.center.lat);
                //alert(e.Result.name);
                //searchCentre = e.Result.center;
            }'
        ]
    ]);

    // add the marker
    $leaflet->addLayer($marker);


	// init the 2amigos leaflet plugin provided by the package
    /*$drawFeature = new \davidjeddy\leaflet\plugins\draw\Draw();
	// optional config array for leadlet.draw
    $drawFeature->options = [
        "position" => "topright",
        "draw" => [
            "circle" => false,
        ],
        
    ];

    if($model->geojson!=null)
        $drawFeature->existingGeojson=$model->geojson;
    else
        $drawFeature->existingGeojson='';

    $drawFeature->setName("drawfeature_name");*/
    $geoCoderPlugin->setName("geocoder_name");

    // Different layers can be added to our map using the `addLayer` function.
   // $leaflet->installPlugin($drawFeature);  // add draw plugin
    $leaflet->installPlugin($geoCoderPlugin); //add geocoder plugin   

    //Create JS
$this->registerJs(<<<JS
    var mapsPlaceholder = [];

    L.Map.addInitHook(function () {
        mapsPlaceholder.push(this); // Use whatever global scope variable you like.
    });

    // set up the mutation observer observe when map is ready
    var observer = new MutationObserver(function (mutations, me) {
        var map2 = mapsPlaceholder.pop();
        if (map2) {
            //placeholder on map search bar
            geocoder_inputs = document.getElementsByClassName('leaflet-geocoder-input');
            for (var i = 0; i < geocoder_inputs.length; i++) {
                geocoder_inputs[i].placeholder='Search Location';
            } 
            
            //set search bar expanded leaflet-control-geocoder-expanded
            geocoder_controller = document.getElementsByClassName('leaflet-control-geocoder');
            for (var i = 0; i < geocoder_controller.length; i++) {
                geocoder_controller[i].classList.add('leaflet-control-geocoder-expanded');
            } 
            me.disconnect(); // stop observing
            return;
        }
    });
    // start observing
    observer.observe(document, {
        childList: true,
        subtree: true
    });
JS
);
    echo $leaflet->widget(['options' => ['style' => 'min-height: 600px']]);
    ?>
