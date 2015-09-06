<?php
  ob_start();
  session_start();
  if (!isset($_SESSION['username'])) {
    header('Location:login.php');
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <meta charset="utf-8">
    <title>Map My Problems</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  </head>
  <body class="main-page">
  <nav class="navbar navbar-default navbar-fixed-top row">
    <div class="container">
      <div class="navbar-header pull-right">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="logout.php">Logout</a>
      </div>
    </div>
  </nav>
  <div class="container map-holder">
    <div class="row map-holder">
      <div class="col-md-4">
        <form action="" method="post" name="form">
          <fieldset>
            <div class="form-group">
              <input class="form-control" placeholder="Complaint Title" name="title" id="title" type="text">
            </div>
            <div class="form-group">
              <textarea class="form-control" name="description" id="description" placeholder="Complaint Description" rows="4"></textarea>
            </div>
            <div class="form-group">
              <input class="form-control" id="pac-input" placeholder="Location" name="location" type="text">
            </div>
            <input class="btn btn-lg btn-success btn-block" id="submit-button" value="Submit">
          </fieldset>
        </form>
        <div id="insert-successful" class="text-center">
        </div>
      </div>
      <div class="col-md-8 map-pane">
        <div id="map"></div>
      </div>
    </div>
  </div>
  <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap"></script>
  </body>
  <script type="text/javascript">
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
      content: contentString,
      maxWidth: 500
    });

    autocomplete.addListener('place_changed', function() {
      try {
        contentString = '';
        infowindow.close();
      }
      catch (err) {
        contentString = '';
      }
      var place = autocomplete.getPlace();
      map.setCenter(place.geometry.location);
      coords.push(place.geometry.location['G']);
      coords.push(place.geometry.location['K']);
      marker.setPosition(place.geometry.location);
      marker.setVisible(true);
      var title = document.getElementById('title').value;
      var description = document.getElementById('description').value;
      var contentString = '<h4 class="report-title">' + title + '</h4>' + '<br>' + '<p class="report-description">' + description + '</p>';
      marker.setTitle(title);
      var infowindow = new google.maps.InfoWindow({
          content: contentString,
          maxWidth: 500
      });
      google.maps.event.addListener(marker, "click", function () {
        infowindow.close();
        infowindow.open(map, this);
        console.log("in autocomplete");
      });
    })

    <?php
      $username = $_SESSION['username'];
      $m = new MongoClient();
      $db = $m -> map;
      $collection = $db -> reports;
      $cursor = $collection -> find();
      echo "var markers = [];";
      $count = 0;
      foreach ($cursor as $doc) {
        echo '
        var site = ["' . htmlentities($doc["title"]) . '","' . $doc["description"] . '","'. 
            htmlentities($doc["username"]).'","'. htmlentities($doc["time"]).'","'. htmlentities($doc["coords"][0]).'","'
            .htmlentities($doc["coords"][0]).'"];' . "\n";
        echo 'var siteLatLng = new google.maps.LatLng('.$doc["coords"][0].', '.$doc["coords"][1].');'."\n";
        echo 'markers.push(new google.maps.Marker({
                position: siteLatLng,
                map: map,
                title: site[0],
                html: site[1]
            }));

            var contentString = site[1];

            google.maps.event.addListener(markers[' . $count . '], "click", function () {
                infowindow.close();
                console.log("in php");
                infowindow.setOptions({maxWidth: 500});
                infowindow.setContent("<h4 class=\'report-title\'>"+this.title+"</h4><br><pclass=\'report-description\'>"+this.html+"</p>");
                infowindow.open(map, this);
            });
          ';
          $count += 1;
      }
    ?>
  }
  </script>
  <script type="text/javascript">
    $(function() {
      $("#submit-button").click(function() {
        var title = $("#title").val();
        var description = $("#description").val();
        var location = $("#pac-input").val();
        var dataString = {'title': title, 'description': description, 'location': location, 'coords': coords};
        $.ajax({
            type: "POST",
            url: "createcomplaint.php",
            data: dataString,
            cache: true,
            success: function (html) {
              document.getElementById('title').value = '';
              document.getElementById('description').value = '';
              document.getElementById('pac-input').value = '';
              document.getElementById('insert-successful').innerHTML = 'Report created successfully.';
            }
          });
        });
      });
  </script>
</html>
