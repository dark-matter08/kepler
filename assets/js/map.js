/* ----- Google Map ----- */
var lng;
console.log(lng);
var lat;
console.log(lat);
var propLocation;
console.log(propLocation);
var propTitle = propLocation;

if(lng == "" || lat == ""){
    lng = 34.8516;
    lat = 31.0461;
    propTitle = "Property Markers not set";
}
lat = parseFloat(lat);
lng = parseFloat(lng);


console.log(lng);
console.log(lat);
console.log(propTitle);
// console.log($("#map").length);
if ($("#map").length) {
    function initialize() {
        var myLatLng = { lat: lat, lng: lng };
        var mapOptions = {
            // SET THE CENTER
            center: myLatLng,
            // SET THE MAP STYLE & ZOOM LEVEL
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: 9,
            // SET THE BACKGROUND COLOUR
            backgroundColor: "#eeeeee",
            // REMOVE ALL THE CONTROLS EXCEPT ZOOM
            panControl: true,
            zoomControl: true,
            mapTypeControl: true,
            scaleControl: true,
            streetViewControl: true,
            overviewMapControl: true,
            scrollwheel: false,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL
            }

        };

        var map = new google.maps.Map(document.getElementById('map'),
            mapOptions);

        // SET THE MAP TYPE
        // var mapType = new google.maps.StyledMapType(style, {name: "Grayscale"});
        // map.mapTypes.set('grey', mapType);
        // map.setMapTypeId('grey');

        var marker = new google.maps.Marker({
            position: { lat: lat, lng: lng },
            icon: 'assets/img/location-pin.png', //if u want custom
            animation: google.maps.Animation.DROP,
            map: map,
            title: propTitle
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
}
