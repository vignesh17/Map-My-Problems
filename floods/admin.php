<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/floods.css">
    <script src="js/jquery.js"></script>
    <meta charset="utf-8">
    <title>#ChennaiFloods2015</title>
    <script src="http://maps.google.com/maps/api/js?v=3.9&amp;libraries=places&amp;sensor=false"></script>
    <script src="js/markerclusterer.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/spider.js"></script>
    <script>


      var coords = [];
      var globalMarkers = [];

      window.onload = function() {

        
        //Map Styles
        var gm = google.maps;
        var chennai = {lat: 13.0846, lng: 80.2179};
        var map = new gm.Map(document.getElementById('map'), {
          zoom: 12,
          center: chennai,
          rotateControl: true,
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
            {"color":"#cccccc"}]},{"featureType":"administrative.locality","elementType":"labels.text",
            "stylers":[{"visibility":"on"}]},{"featureType":"administrative.locality",
            "elementType":"labels.text.fill","stylers":[{"color":"#cccccc"}]},
            {"featureType":"administrative.locality","elementType":"labels.icon","stylers":[
            {"color":"#ff0000"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text",
            "stylers":[{"color":"#cccccc"}]},{"featureType":"administrative.neighborhood",
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
            "stylers":[{"color":"#34687d"},{"lightness":0}]}
          ]
        });

        //custom map controls

        //Roads
        var roadsFlag = 0;

        function CenterControlRoads(controlDiv, map) {

          
          // Set CSS for the control border.
          var controlUI = document.createElement('div');
          controlUI.style.backgroundColor = '#fff';
          controlUI.style.borderLeft = '1px solid black';
          controlUI.style.cursor = 'pointer';
          controlUI.style.marginBottom = '22px';
          controlUI.style.marginTop = '5px';
          controlUI.style.textAlign = 'center';
          controlDiv.appendChild(controlUI);

          // Set CSS for the control interior.
          var controlText = document.createElement('div');
          controlText.style.color = 'rgb(25,25,25)';
          controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
          controlText.style.fontSize = '11px';
          controlText.style.lineHeight = '18px';
          controlText.style.paddingLeft = '2px';
          controlText.style.paddingRight = '2px';
          controlText.innerHTML = 'Highlight Roads';
          controlUI.appendChild(controlText);

          // Setup the click event listeners
          controlUI.addEventListener('click', function() {
            if (roadsFlag == 0) {
              roadsFlag = 1;
              controlText.style.fontWeight = 'bolder';
              map.setOptions({
              rotateControl: true,
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
              {"color":"#cccccc"}]},{"featureType":"administrative.locality","elementType":"labels.text",
              "stylers":[{"visibility":"on"}]},{"featureType":"administrative.locality",
              "elementType":"labels.text.fill","stylers":[{"color":"#cccccc"}]},
              {"featureType":"administrative.locality","elementType":"labels.icon","stylers":[
              {"color":"#ff0000"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text",
              "stylers":[{"color":"#cccccc"}]},{"featureType":"administrative.neighborhood",
              "elementType":"labels.text.stroke","stylers":[{"weight":"1.45"},{"gamma":"1.30"},
              {"lightness":"-13"},{"saturation":"-11"}]},{"featureType":"landscape",
              "elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},
              {"featureType":"landscape.natural.terrain","elementType":"geometry","stylers":[
              {"saturation":"-4"},{"lightness":"2"},{"gamma":"1.35"}]},{"featureType":"poi",
              "elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},
              {"featureType":"road.highway","elementType":"geometry.fill","stylers":[
              {"color":"#FFFFFF"},{"lightness":17}]},{"featureType":"road.highway",
              "elementType":"geometry.stroke","stylers":[{"color":"#FFFFFF"},{"lightness":29},
              {"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[
              {"color":"#FFFFFF"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry",
              "stylers":[{"color":"#FFFFFF"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry",
              "stylers":[{"color":"#FFFFFF"},{"lightness":19}]},{"featureType":"water","elementType":"geometry",
              "stylers":[{"color":"#34687d"},{"lightness":0}]}
              ]
            });
            } 
            else{
              roadsFlag = 0;
              controlText.style.fontWeight = 'initial';
              map.setOptions({
              rotateControl: true,
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
                {"color":"#cccccc"}]},{"featureType":"administrative.locality","elementType":"labels.text",
                "stylers":[{"visibility":"on"}]},{"featureType":"administrative.locality",
                "elementType":"labels.text.fill","stylers":[{"color":"#cccccc"}]},
                {"featureType":"administrative.locality","elementType":"labels.icon","stylers":[
                {"color":"#ff0000"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text",
                "stylers":[{"color":"#cccccc"}]},{"featureType":"administrative.neighborhood",
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
                "stylers":[{"color":"#34687d"},{"lightness":0}]}
              ]
            });
            };
            
          });

        }

        // Create the DIV to hold the control and call the CenterControl() constructor
        // passing in this DIV.
        var centerControlDivRoads = document.createElement('div');
        var centerControlRoads = new CenterControlRoads(centerControlDivRoads, map);

        centerControlDivRoads.index = 1;
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDivRoads);

        //Traffic View
        var trafficFlag = 0;
        var trafficLayer = new google.maps.TrafficLayer();

        function CenterControlTraffic(controlDiv, map) {

          
          // Set CSS for the control border.
          var controlUI = document.createElement('div');
          controlUI.style.backgroundColor = '#fff';
          controlUI.style.borderLeft = '1px solid black';
          controlUI.style.cursor = 'pointer';
          controlUI.style.marginBottom = '22px';
          controlUI.style.marginTop = '5px';
          controlUI.style.textAlign = 'center';
          controlDiv.appendChild(controlUI);

          // Set CSS for the control interior.
          var controlText = document.createElement('div');
          controlText.style.color = 'rgb(25,25,25)';
          controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
          controlText.style.fontSize = '11px';
          controlText.style.lineHeight = '18px';
          controlText.style.paddingLeft = '2px';
          controlText.style.paddingRight = '2px';
          controlText.innerHTML = 'Live Traffic';
          controlUI.appendChild(controlText);

          // Setup the click event listeners
          controlUI.addEventListener('click', function() {
            if (trafficFlag == 0) {
              trafficFlag = 1;
              controlText.style.fontWeight = 'bolder';
              trafficLayer.setMap(map);
            } 
            else{
              trafficFlag = 0;
              controlText.style.fontWeight = 'initial';
              trafficLayer.setMap(null);
            };
            
          });

        }

        var centerControlDivTraffic = document.createElement('div');
        var centerControlTraffic = new CenterControlTraffic(centerControlDivTraffic, map);

        centerControlDivTraffic.index = 1;
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDivTraffic);



        
        //Initialise infowindows and OMS
        var iw = new gm.InfoWindow();
        var oms = new OverlappingMarkerSpiderfier(map,
          {markersWontMove: true, markersWontHide: true});


        //OMS Open infowindow on click
        oms.addListener('click', function(marker) {
          iw.setContent(marker.info);
          iw.setOptions({maxWidth: 500});
          iw.open(map, marker);
        });

        //OMS Spiderfy markers
        oms.addListener('spiderfy', function(markers) {
          for(var i = 0; i < markers.length; i ++) {
            if (markers[i].iconBig == true) {
              markers[i].setIcon({
                path: google.maps.SymbolPath.CIRCLE,
                strokeColor: markers[i].markerColorTemp,
                scale: 8,
                strokeWeight: 16,
                strokeOpacity: 0.9
              });
            }
            else {
              markers[i].setIcon({
                path: google.maps.SymbolPath.CIRCLE,
                strokeColor: markers[i].markerColorTemp,
                scale: 4,
                strokeWeight: 8,
                strokeOpacity: 0.9
              });
            }
          } 
          iw.close();
        });

        //OMS Unspiderfy markers
        oms.addListener('unspiderfy', function(markers) {
          for(var i = 0; i < markers.length; i ++) {
            markers[i].setIcon({
              path: google.maps.SymbolPath.CIRCLE,
              strokeColor: markers[i].markerColorTemp,
              scale: 4,
              strokeWeight: 8,
              strokeOpacity: 0.9
            });
            markers[i].setAnimation(markers[i].getAnimation());
          }
        });
        
        var bounds = new gm.LatLngBounds();

        for (var i = 0; i < window.mapData.length; i ++) {
          var datum = window.mapData[i];
          var loc = new gm.LatLng(datum.lat, datum.lon);
          var markerColor = datum.markerColor;
          var markerId = datum.id;
          var anim = datum.animation;
          bounds.extend(loc);

          var comments = "";
          if(datum.comments.length > 0) {
            comments = "<ul>";
            for (var iterator = datum.comments.length - 1; iterator >= 0; iterator--) {
              if(1) {
                comments = comments + "<li>"+datum.comments[iterator]+"</li>";
              }
            }
            comments += "</ul>";
          }
          
          var marker = new gm.Marker({
            position: loc,
            map: map,
            id: markerId,
            markerColorTemp: markerColor,
            iconBig: true,
            //icon: iconWithColor(markerColor),
            icon: {
              path: google.maps.SymbolPath.CIRCLE,
              strokeColor: markerColor,
              scale: 4,
              strokeWeight: 8,
              strokeOpacity: 0.9,
            },
            animation: anim,
            info: "<h4 class='report-title'>"+datum.type+"</h4><br><p class='report-desc'>"+datum.html+"<br>Location: "+datum.location+"<br>Contact: <br>"+datum.person+"  at   "+datum.contact+"</p><br><h5>Comments</h5>"+comments+"<br><form class='form-group' method='post' action='comment.php?id="+datum.id+"'><div><input placeholder='eg. I will take care - siva, 944444444' class='form-control' type=text name='comment'></div><br><input class='btn btn-success btn-block' type='submit' value='Post Comment'>"
          });

          marker.title = datum.type;
          oms.addMarker(marker);
          globalMarkers.push(marker);
          comments = "";
        }
        map.fitBounds(bounds);
        
        window.map = map;
        window.oms = oms;

        var markerClusterer = new MarkerClusterer(window.map, globalMarkers);
        markerClusterer.setMaxZoom(13);

      }

    </script>
  </head> 
  <body class="main-page">

    <div class="container map-holder">
      <div class="row map-holder">
        <div class="col-md-4 legends">
          Legends
          <ul>
            <li>Red - Medical</li>
            <li>Blue - Rescue</li>
            <li>Green - Food</li>
            <li>White - Clothing</li>
            <li>Yellow - Others</li>
          </ul>
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
      $collection = $db -> floods;
      $cursor = $collection -> find(); 

      foreach ($cursor as $doc) {
        if ($doc["type"] == "rescue") {
          echo 'data.push({
                lon:'.$doc["coords"][1].',
                lat: '.$doc["coords"][0].',
                location: "'.$doc["location"].'",
                type: "'.$doc["type"] .'",
                html: "'.$doc["details"] .'",
                id: "'.$doc["_id"].'",
                person: "'.$doc["person"].'",
                contact: "'.$doc["contact"].'",
                comments: ' . json_encode($doc["comments"]) . ',
                markerColor: "' . '#0000ff' . '",
              });
            ';        
        }
        elseif ($doc["type"] == "food") {
          echo 'data.push({
                lon:'.$doc["coords"][1].',
                lat: '.$doc["coords"][0].',
                location: "'.$doc["location"].'",
                type: "'.$doc["type"] .'",
                html: "'.$doc["details"] .'",
                id: "'.$doc["_id"].'",
                person: "'.$doc["person"].'",
                contact: "'.$doc["contact"].'",
                comments: ' . json_encode($doc["comments"]) . ',
                markerColor: "' . '#00ff00' . '",
              });
            ';        
        }
        elseif ($doc["type"] == "clothing") {
          echo 'data.push({
                lon:'.$doc["coords"][1].',
                lat: '.$doc["coords"][0].',
                location: "'.$doc["location"].'",
                type: "'.$doc["type"] .'",
                html: "'.$doc["details"] .'",
                id: "'.$doc["_id"].'",
                person: "'.$doc["person"].'",
                contact: "'.$doc["contact"].'",
                comments: ' . json_encode($doc["comments"]) . ',
                markerColor: "' . '#ffffff' . '",
              });
            ';        
        }
        elseif ($doc["type"] == "medical") {
          echo 'data.push({
                lon:'.$doc["coords"][1].',
                lat: '.$doc["coords"][0].',
                location: "'.$doc["location"].'",
                type: "'.$doc["type"] .'",
                html: "'.$doc["details"] .'",
                id: "'.$doc["_id"].'",
                person: "'.$doc["person"].'",
                contact: "'.$doc["contact"].'",
                comments: ' . json_encode($doc["comments"]) . ',
                markerColor: "' . '#ff0000' . '",
              });
            ';        
        }
        else {
          echo 'data.push({
                lon:'.$doc["coords"][1].',
                lat: '.$doc["coords"][0].',
                location: "'.$doc["location"].'",
                type: "'.$doc["type"] .'",
                html: "'.$doc["details"] .'",
                id: "'.$doc["_id"].'",
                person: "'.$doc["person"].'",
                contact: "'.$doc["contact"].'",
                comments: ' . json_encode($doc["comments"]) . ',
                markerColor: "' . '#ffff00' . '",
              });
            ';   
        }
        
      }

    ?>

    window.mapData = data;
    
    </script>
  </body>
</html>
