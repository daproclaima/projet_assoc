// Initialize and add the map
function initMap() {
    // Localisation
    var wf3 = {lat: 48.819, lng: 1.981};
    // Centrage de la map sur la localisation
    var map = new google.maps.Map(
        document.getElementById('map'), {zoom:25, center: wf3});
    // Positionnement du marqueur de position sur la carte
    var marker = new google.maps.Marker({position: wf3, map: map});
}