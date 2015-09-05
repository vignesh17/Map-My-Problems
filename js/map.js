var coords = [];

function initMap() {
  var chennai = {lat: 13.0846, lng: 80.2179};
  var input = /** @type {!HTMLInputElement} */(
      document.getElementById('pac-input'));
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: chennai,
    styles: [
      {"featureType":"all","elementType":"labels.text.fill",
        "stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},
        {"featureType":"all","elementType":"labels.text.stroke","stylers":[
        {"visibility":"on"},{"color":"#000000"},{"lightness":16}]},
        {"featureType":"all","elementType":"labels.icon","stylers":[
        {"visibility":"off"}]},{"featureType":"administrative",
        "elementType":"geometry.fill","stylers":[{"color":"#000000"},
        {"lightness":20}]},{"featureType":"administrative",
        "elementType":"geometry.stroke","stylers":[{"color":"#000000"},
        {"lightness":17},{"weight":1.2}]},{"featureType":"administrative.country",
        "elementType":"geometry","stylers":[{"visibility":"on"},{"hue":"#ff0000"}]},
        {"featureType":"administrative.province","elementType":"geometry","stylers":[
        {"color":"#ffffff"}]},{"featureType":"administrative.locality","elementType":"labels.text",
        "stylers":[{"visibility":"on"}]},{"featureType":"administrative.locality",
        "elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},
        {"featureType":"administrative.locality","elementType":"labels.icon","stylers":[
        {"color":"#ff0000"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text",
        "stylers":[{"color":"#ffffff"}]},{"featureType":"administrative.neighborhood",
        "elementType":"labels.text.stroke","stylers":[{"weight":"1.45"},{"gamma":"1.30"},
        {"lightness":"-13"},{"saturation":"-11"}]},{"featureType":"landscape",
        "elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},
        {"featureType":"landscape.natural.terrain","elementType":"geometry","stylers":[
        {"saturation":"-4"},{"lightness":"2"},{"gamma":"1.35"}]},{"featureType":"poi",
        "elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},
        {"featureType":"road.highway","elementType":"geometry.fill","stylers":[
        {"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway",
        "elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},
        {"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[
        {"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry",
        "stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry",
        "stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry",
        "stylers":[{"color":"#34687d"},{"lightness":17}]}
    ]
  });

  var contentString = '';

  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.bindTo('bounds', map);

  var marker = new google.maps.Marker({
    map: map
  });

  var infowindow = new google.maps.InfoWindow({
    content: contentString
  });

  autocomplete.addListener('place_changed', function() {
    try {
      infowindow.close();
    }
    catch (err) {
      contentString = '';
    }
    var place = autocomplete.getPlace();
    map.setCenter(place.geometry.location);
    coords.push(place.geometry.location['G']);
    coords.push(place.geometry.location['K']);
    map.setZoom(16);
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);
    var title = document.getElementById('title').value;
    var description = document.getElementById('description').value;
    var contentString = '<h4>' + title + '</h4>' + '<br>' + '<p>' + description + '</p>';
    marker.setTitle(title);
    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });
    marker.addListener('click', function() {
      infowindow.open(map, marker);
    });

  })
}
