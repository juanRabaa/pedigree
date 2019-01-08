jQuery(function($) {
    // Asynchronously Load the map API
    var script = document.createElement('script');
    script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyAM1DDlxnTGYuT1LcctSVEsbkVcRv6kj_Y&libraries=places&callback=initMap";
    document.body.appendChild(script);
});

var map, infoWindow, service, geocoder;

//console.log(wp_data.places);

function initMap() {
    //console.log("Init map");
    map = new google.maps.Map(document.getElementById('stores-map'), {
      center: {lat: -34.607797, lng: -58.415168},
      zoom: 12
    });
    infoWindow = new google.maps.InfoWindow;
    service = new google.maps.places.PlacesService(map);
    //geocoder = new google.maps.Geocoder;

    var markers = null;
    if(wp_data.places){
        markers = wp_data.places.map(function(place, i) {
            var lat = parseFloat(place.lat);
            var lng = parseFloat(place.lng);
            //console.log(place.name, lat, lng);
            if( lat != 0 && lng != 0){
                //console.log(place);
                var marker = new google.maps.Marker({
                    position: { lat: lat, lng: lng },
                    map: map,
                    icon: wp_data.markerIcon,
                });
                //console.log( getPlaceIdByLocation({ lat: lat, lng: lng }) );

                // =================================================================
                // PLACE DETAILS on click
                // =================================================================
                google.maps.event.addListener(marker, 'click', function() {
                    //console.log(place);
                    var boxHtml = getPlaceDetailBox(place);
                    infoWindow.setContent(boxHtml);
                  infoWindow.open(map, this);
                });

                return marker;
            }
            return null;
        });
    }


    initAutocomplete();
}

// =============================================================================
// SEARCH INPUT
// =============================================================================
function initAutocomplete() {
     // Create the search box and link it to the UI element.
     var input = document.getElementById('map-address-search');
     var searchBox = new google.maps.places.SearchBox(input);
     //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

     // Bias the SearchBox results towards current map's viewport.
     map.addListener('bounds_changed', function() {
       searchBox.setBounds(map.getBounds());
     });

     var markers = [];
     // Listen for the event fired when the user selects a prediction and retrieve
     // more details for that place.
     searchBox.addListener('places_changed', function() {
       var places = searchBox.getPlaces();

       if (places.length == 0) {
         return;
       }

       map.setZoom(12);

       // Clear out the old markers.
       markers.forEach(function(marker) {
         marker.setMap(null);
       });
       markers = [];

       // For each place, get the icon, name and location.
       var bounds = new google.maps.LatLngBounds();

       places.forEach(function(place) {
         if (!place.geometry) {
           //console.log("Returned place contains no geometry");
           return;
         }
         var icon = {
           url: place.icon,
           size: new google.maps.Size(71, 71),
           origin: new google.maps.Point(0, 0),
           anchor: new google.maps.Point(17, 34),
           scaledSize: new google.maps.Size(25, 25)
         };

         // Create a marker for each place.
         markers.push(new google.maps.Marker({
           map: map,
           icon: icon,
           title: place.name,
           position: place.geometry.location
         }));

         if (place.geometry.viewport) {
           // Only geocodes have viewport.
           bounds.union(place.geometry.viewport);
         } else {
           bounds.extend(place.geometry.location);
         }
       });
       map.fitBounds(bounds);
       map.setZoom(12);
     });
}

// =============================================================================
// GEOLOCATION
// =============================================================================
function runGeolocation(){
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };

        infoWindow.setPosition(pos);
        infoWindow.setContent('Esta es tu ubicación.');
        infoWindow.open(map);
        map.setCenter(pos);
        map.setZoom(12);
      }, function() {
        handleLocationError(true, infoWindow, map.getCenter());
      });
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, map.getCenter());
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
  infoWindow.open(map);
}

// =============================================================================
// GEOCODER
// =============================================================================
function getPlaceIdByLocation( location ){
    var placeId = null;
    geocoder.geocode({'location': location}, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                placeId = results[1].place_id;
                //console.log(results);
            }
        }
    });
    return placeId;
}

// =============================================================================
// DETAIL BOX
// =============================================================================
function getPlaceDetailBox(place){
    const { address, name, phone, email, url, timetable } = place;
    var finalHtml = '<div class="place-info-popup">';

    if( name ){
        finalHtml += `
        <div class="popup-header text-center">
            <p class="info">${name}</p>
        </div>
        `;
    }
    if( address ){
        finalHtml += `
        <div class="item-info">
            <div class="icon pedigree-main-color"><i class="fas fa-map-marker-alt"></i></div>
            <p class="info">${address}</p>
        </div>
        `;
    }
    if( timetable ){
        finalHtml += `
        <div class="item-info">
            <div class="icon pedigree-main-color"><i class="far fa-clock"></i></div>
            <p class="info">${timetable}</p>
        </div>
        `;
    }
    if( phone ){
        finalHtml += `
        <div class="item-info">
            <div class="icon pedigree-main-color"><i class="fas fa-phone"></i></div>
            <p class="info"><a href="tel:+${phone}" data-rel="external">${phone}</a></p>
        </div>
        `;
    }
    if( url ){
        finalHtml += `
        <div class="item-info">
            <div class="icon pedigree-main-color"><i class="fas fa-globe"></i></div>
            <p class="info"><a target="_blank" href="${url}">${url}</a></p>
        </div>
        `;
    }
    if( email ){
        finalHtml += `
        <div class="item-info">
            <div class="icon pedigree-main-color"><i class="fas fa-envelope"></i></div>
            <p class="info"><a href="mailto:${email}" data-rel="external">${email}</a></p>
        </div>
        `;
    }

    finalHtml += '</div>';
    return finalHtml;
}

// =============================================================================
// HANDLERS
// =============================================================================
$(document).ready(function(){
    $("#geolocation-button").click(function(){
        //console.log('Geolocation button clicked');
        runGeolocation();
    });

    var searchInputDisplayed = false;
    $("#search-button").click(function(){
        var $title = $(this).find('.btn-title');
        var $input = $(this).find('.map-search-container');

        $title.animate({
            width: 0,
            padding: 0,
            opacity: 0,
        }, 200, function(){
            $title.css('display', 'none');
        });

        $input.animate({
            width: '100%',
            borderWidth: '0.1rem',
        });
    });
});
