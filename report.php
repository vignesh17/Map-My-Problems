<?php
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
  <script async defer
        src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap"></script>
  </body>
  <script type="text/javascript">
    <?php
      $username = $_SESSION['username'];
      $m = new MongoClient();
      $db = $m -> map;
      $collection = $db -> reports;
      $cursor = $collection -> find();
      /*echo "
        var geocoder = new google.maps.Geocoder();
        var markers = [];
      ";
      foreach ($cursor as $doc) {
        echo "
        var address = '" . $doc["location"] . "';";
        echo "\n";
        echo "geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            markers.push(results[0].geometry.location);
          } 
          else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
        ";
        //var_dump($doc["location"]);
      }*/
    ?>
  </script>
  <script type="text/javascript" src="js/map.js"></script>
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
