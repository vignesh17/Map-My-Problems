function initMap() {
  var uluru = {lat: 13.0846, lng: 80.2179};
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: uluru,
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

  var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
      '<div id="bodyContent">'+
      '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
      'sandstone rock formation in the southern part of the '+
      'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) '+
      'south west of the nearest large town, Alice Springs; 450&#160;km '+
      '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major '+
      'features of the Uluru - Kata Tjuta National Park. Uluru is '+
      'sacred to the Pitjantjatjara and Yankunytjatjara, the '+
      'Aboriginal people of the area. It has many springs, waterholes, '+
      'rock caves and ancient paintings. Uluru is listed as a World '+
      'Heritage Site.</p>'+
      '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
      'https://en.wikipedia.org/w/index.php?title=Uluru</a> '+
      '(last visited June 22, 2009).</p>'+
      '</div>'+
      '</div>';

  var infowindow = new google.maps.InfoWindow({
    content: contentString
  });

  var marker = new google.maps.Marker({
    position: uluru,
    map: map,
    title: 'Uluru (Ayers Rock)'
  });
  marker.addListener('click', function() {
    infowindow.open(map, marker);
  });
}
