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
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js"></script>
    <script src="http://maps.google.com/maps/api/js?v=3.9&amp;libraries=places&amp;sensor=false"></script>
    <script type="text/javascript" src="js/spider.js"></script>
    <script>
      var coords = [];

      window.onload = function() {

        var input = document.getElementById('pac-input');
        
        var gm = google.maps;
        var chennai = {lat: 13.0846, lng: 80.2179};
        var map = new gm.Map(document.getElementById('map'), {
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
        
        var iw = new gm.InfoWindow();
        var oms = new OverlappingMarkerSpiderfier(map,
          {markersWontMove: true, markersWontHide: true});

        var usualColor = 'FF9933';
        var spiderfiedColor = 'ffee22';
        var iconWithColor = function(color) {
          return 'http://chart.googleapis.com/chart?chst=d_map_xpin_letter&chld=pin|+|' +
            color + '|000000|ffff00';
        }
        
        var shadow = new gm.MarkerImage(
          'https://www.google.com/intl/en_ALL/mapfiles/shadow50.png',
          new gm.Size(37, 34),  // size   - for sprite clipping
          new gm.Point(0, 0),   // origin - ditto
          new gm.Point(10, 34)  // anchor - where to meet map location
        );

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
        autocomplete.addListener('place_changed', function() {
          var place = autocomplete.getPlace();
          coords = [];
          coords.push(place.geometry.location['A']);
          coords.push(place.geometry.location['F']);
        })

        oms.addListener('click', function(marker) {
          iw.setContent(marker.info);
          iw.setOptions({maxWidth: 500});
          iw.open(map, marker);
        });

        oms.addListener('spiderfy', function(markers) {
          for(var i = 0; i < markers.length; i ++) {
            markers[i].setIcon(iconWithColor(spiderfiedColor));
            markers[i].setShadow(null);
          } 
          iw.close();
        });

        oms.addListener('unspiderfy', function(markers) {
          for(var i = 0; i < markers.length; i ++) {
            markers[i].setIcon(iconWithColor(usualColor));
            markers[i].setShadow(shadow);
          }
        });
        
        var bounds = new gm.LatLngBounds();
        for (var i = 0; i < window.mapData.length; i ++) {
          var datum = window.mapData[i];
          var loc = new gm.LatLng(datum.lat, datum.lon);
          bounds.extend(loc);

          var comments = "<ul>"
          for (var iterator = datum.comments.length - 1; iterator >= 0; iterator--) {
            comments = comments + "<li>"+datum.comments[iterator]+"&nbsp;<strong>Posted By "+datum.commenters[iterator]+"</strong></li>";
          }
          comments += "</ul>";
          

          var marker = new gm.Marker({
            position: loc,
            map: map,
            icon: iconWithColor(usualColor),
            shadow: shadow,
            info: "<h4 class='report-title'>"+datum.title+"</h4><h6>Currently voted by "+datum.votes+" people<br><br><a href='vote.php?vote=up&id="+datum.id+'&user='+datum.user+"'>"+"Vote Up</a>"+"\n"+"&nbsp;&nbsp;&nbsp;<a href='vote.php?vote=down&id="+datum.id+'&user='+datum.user+"'>"+"Vote Down</a>"+"\n"+"<br><br><br><p class='report-desc'>"+datum.html+"</p><br><h5>Comments</h5>"+comments+"<br><form class='form-group' method='post' action='comment.php?id="+datum.id+'&user='+datum.user+"'><div><input class='form-control' type=text name='comment'></div><br><input class='btn btn-success btn-block' type='submit' value='Post Comment'>"
          });
          marker.title = datum.title;
          oms.addMarker(marker);
          comments = "";
        }
        map.fitBounds(bounds);

        window.map = map;
        window.oms = oms;

        $(function() {

          $("#submit-button").click(function() {

            var title = $("#title").val();
            var description = $("#description").val();
            var location = $("#pac-input").val();
            var dataString = {'title': title, 'description': description, 'location': location, 'coords': coords};
            
            if(coords.length == 0) {
                  document.getElementById('insert-successful').innerHTML = 'Invalid Location';
            }

            else {

              $.ajax({

                type: "POST",
                url: "createcomplaint.php",
                data: dataString,
                cache: true,
                success: function (html) {

                  document.getElementById('title').value = '';
                  document.getElementById('description').value = '';
                  document.getElementById('pac-input').value = '';

                  var loc = new google.maps.LatLng(coords[0], coords[1]);
                  bounds.extend(loc);
                  var marker = new google.maps.Marker({
                    position: loc,
                    map: map,
                    icon: iconWithColor(usualColor),
                    shadow: shadow,
                    info: "<h4 class='report-title'>"+title+"</h4>\n"+"<br><p class='report-desc'>"+description+"</p>"
                  });

                  oms.addMarker(marker);  
                  document.getElementById('insert-successful').innerHTML = 'Report created successfully.';

                }
              });
            }

          });
        });

      }
    </script>
  </head> 
  <body class="main-page">

    <nav class="navbar navbar-default row">
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
                <input class="form-control" data-validation="length normaltext" data-validation-length="min8" placeholder="Complaint Title" name="title" id="title" type="text">
              </div>
              <div class="form-group">
                <textarea class="form-control" data-validation="length normaltext" data-validation-length="min50 max300" name="description" id="description" placeholder="Complaint Description" rows="4"></textarea>
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

    <script type="text/javascript">

    //Add markers from db
    var data = [];
    <?php

      $m = new MongoClient();
      $db = $m -> map;
      $collection = $db -> reports;
      $cursor = $collection -> find();

      foreach ($cursor as $doc) {

        echo 'data.push({
            lon:'.$doc["coords"][1].',
            lat: '.$doc["coords"][0].',
            title: "'.$doc["title"] .'",
            html: "'.$doc["description"] .'",
            id: "'.$doc["_id"].'",
            user: "'.$_SESSION["username"].'",
            votes: '.$doc["votes"].',
            comments: ['.'"'.implode('","',  $doc["comments"] ).'"'.'],
            commenters: ['.'"'.implode('","',  $doc["commenters"] ).'"'.'],
          });
          ';
      }
    ?>
    window.mapData = data;
    
    </script>
    <script> 
        $.validate(); 
        $.formUtils.addValidator({
          name : 'normaltext',
          validatorFunction : function(value, $el, config, language, $form) {
            return /^[\.\-\/\\1-9a-z\s]+$/i.test(value);
          },
          errorMessage : 'Invalid characters present in the entered text.',
          errorMessageKey: 'onlyLetters'
        });
    </script>
  </body>
</html>
