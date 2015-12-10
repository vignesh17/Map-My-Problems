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
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<title>Map My Problems</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js"></script>
		<script src="http://maps.google.com/maps/api/js?v=3.9&amp;libraries=places&amp;sensor=false"></script>
		<script src="js/markerclusterer.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/spider.js"></script>
		<script>
			//coords stores the {lat, lng} of the autocomplete field
			//globalMarkers contains all the map markers
			var coords = [];
			var globalMarkers = [];

			window.onload = function() {

				//handle loading progress
				$('#finished-load').css({
					visibility 	: 'visible',
					height 		: 'initial'
				});
				$('#page-loading').remove();

				
				//Map Styles
				var gm 	= google.maps;
				var chennai = {
					lat: 13.0846, 
					lng: 80.2179
				};
				var map = new gm.Map(document.getElementById('map'), {
					zoom			: 12,
					center 			: chennai,
					rotateControl	: true,
					styles 			: [
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

				//beginning of custom map controls

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
				  	//roadsFlag checks if the toggle is already set
				  	if (roadsFlag == 0) {
				  		roadsFlag = 1;
				  		controlText.style.fontWeight = 'bolder';
				  		map.setOptions({
							rotateControl 	: true,
							styles 			: [
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
							rotateControl 	: true,
							styles 			: [
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

				// Create a div to hold the control, call the CenterControl() constructor
				// and add it to the map
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
				  	else {
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


				//Closed Complaints

				function CenterControlClosed(controlDiv, map) {				  
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
				  if (sessionStorage.closed == 1) {
				  	controlText.style.fontWeight = 'bolder';
				  }
				  else {
				  	controlText.style.fontWeight = 'initial';
				  }
				  controlText.innerHTML = 'Toggle Closed Complaints';
				  controlUI.appendChild(controlText);

				  // Setup the click event listeners
				  controlUI.addEventListener('click', function() {
				  	if (sessionStorage.closed) {
				  		if (sessionStorage.closed == 0) {
					  		sessionStorage.closed = 1;
					  		window.location = 'report.php?closed=true';
					  	} 
					  	else{
					  		sessionStorage.closed = 0;
	  						window.location = 'report.php';
					  	};
				  	}
				  	else {
				  		sessionStorage.closed = 1;
				  		controlText.style.fontWeight = 'bolder';
					  	window.location = 'report.php?closed=true';
				  	}
				  	
				    
				  });

				}

				var centerControlDivClosed = document.createElement('div');
				var centerControlTraffic = new CenterControlClosed(centerControlDivClosed, map);

				centerControlDivClosed.index = 1;
				map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDivClosed);

				//end of custom map controls

				//Initialise infowindows and OMS
				var iw = new gm.InfoWindow();
				var oms = new OverlappingMarkerSpiderfier(
					map, {
						markersWontMove: true, 
						markersWontHide: true
					}
				);

				//OMS Open infowindow on click
				oms.addListener('click', function(marker) {
					iw.setContent(marker.info);
					iw.setOptions({maxWidth: 500});
					iw.open(map, marker);
				});

				//OMS Spiderfy markers
				//also check if the votes are more than the cutoff
				oms.addListener('spiderfy', function(markers) {
					for(var i = 0; i < markers.length; i ++) {
						if (markers[i].iconBig == true) {
							markers[i].setIcon({
								path 			: google.maps.SymbolPath.CIRCLE,
								strokeColor 	: markers[i].markerColorTemp,
								scale 			: 8,
								strokeWeight 	: 16,
								strokeOpacity 	: 0.9
							});
						}
						else {
							markers[i].setIcon({
								path 			: google.maps.SymbolPath.CIRCLE,
								strokeColor 	: markers[i].markerColorTemp,
								scale 			: 4,
								strokeWeight 	: 8,
								strokeOpacity 	: 0.9
							});
						}
					} 
					iw.close();
				});

				//OMS Unspiderfy markers
				oms.addListener('unspiderfy', function(markers) {
					for(var i = 0; i < markers.length; i ++) {
						markers[i].setIcon({
							path 			: google.maps.SymbolPath.CIRCLE,
							strokeColor 	: markers[i].markerColorTemp,
							scale 			: 4,
							strokeWeight 	: 8,
							strokeOpacity 	: 0.9
						});
						markers[i].setAnimation(markers[i].getAnimation());
					}
				});
				
				//create comments innerHTML
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
							//check if the commenter is an admin and add official label to him.
								if (datum.commenters[iterator].endsWith('~admin')) {
									comments = comments + 
										"<li><strong>" + 
										datum.commenters[iterator].replace('~admin', '') + 
										"<div class='label label-info'>Official</div>:</strong>&nbsp;" + 
										datum.comments[iterator] + "</li>";
								} 
								else {
									comments = comments + 
										"<li><strong>" + 
										datum.commenters[iterator] + 
										":</strong>&nbsp; " + datum.comments[iterator] + "</li>";	
								}
						}
						comments += "</ul>";
					}
					
					//display bigger markers for complaints with more votes
					var voteCutOff = 100;
					var infoBuilder = "<h4 class='report-title'>" + 
						datum.title + "</h4><h5>Tagged at: " + datum.taggedAt + 
						"</h5>Posted on: " + datum.date + "<h6>Currently voted by " + 
						datum.votes + " people" + "\n" + 
						"<br><br><br><p class='report-desc'>" + datum.html + 
						"</p><br><a href='vote.php?vote=up&id=" + datum.id + 
						'&user=' + datum.user + "'>" + 
						"<i title='Vote Up' class='fa fa-thumbs-up'></i></a>" + 
						"\n" + "&nbsp;&nbsp;&nbsp;<a href='vote.php?vote=down&id=" + 
						datum.id + '&user=' + datum.user + "'>" + 
						"<i title='Vote Down' class='fa fa-thumbs-down'></i></a><h5>Comments</h5>" + 
						comments + "<br><form class='form-group' method='post' action='comment.php?id=" +
						datum.id + '&user=' + datum.user + "'><div>" + 
						"<input class='form-control' type=text name='comment'></div><br>" + 
						"<input class='btn btn-success btn-block' type='submit' value='Post Comment'>";
					if (datum.votes < voteCutOff) {
						var marker = new gm.Marker({
							position 			: loc,
							map 				: map,
							id 					: markerId,
							markerColorTemp 	: markerColor,
							iconBig 			: false,
							icon 				: {
								path 			: google.maps.SymbolPath.CIRCLE,
								strokeColor 	: markerColor,
								scale 			: 4,
								strokeWeight 	: 8,
								strokeOpacity 	: 0.9,
							},
							animation 			: anim,
							info 				: infoBuilder
						});
					}
					else {
						var marker = new gm.Marker({
							position 			: loc,
							map 				: map,
							id 					: markerId,
							markerColorTemp 	: markerColor,
							iconBig 			: true,
							icon 				: {
								path 			: google.maps.SymbolPath.CIRCLE,
								strokeColor 	: markerColor,
								scale 			: 8,
								strokeWeight 	: 16,
								strokeOpacity 	: 0.9,
							},
							animation 			: anim,
							info 				: infoBuilder
						});
					}

					marker.title = datum.title;
					oms.addMarker(marker);
					globalMarkers.push(marker);
				}

				//set map bounds and load the map and oms
				map.fitBounds(bounds);
				window.map = map;
				window.oms = oms;

				//set markerClusterer on the map.
				var markerClusterer = new MarkerClusterer(window.map, globalMarkers);
				markerClusterer.setMaxZoom(13);

				<?php

					//handle already voted upon scenarios
					if (isset($_SESSION["voteError"])) {
						if ($_SESSION["voteError"] == 1) {
							echo "window.alert('You have already upvoted this.');";
							unset($_SESSION["voteError"]);
						}
						else if ($_SESSION["voteError"] == -1) {
							echo "window.alert('You have already downvoted this.');";
							unset($_SESSION["voteError"]);
						}            
					}

					//open the infowindow after voting redirects
					if (isset($_SESSION["votedId"])) {
						echo 'var availMarkers = oms.getMarkers();';
						echo 'var toBeOpened = $.grep(availMarkers, function(e){ return e.id == "' . $_SESSION["votedId"] . '"; })[0];';
						echo 'iw.setContent(toBeOpened.info);';
						echo 'iw.setOptions({maxWidth: 500});';
						echo 'iw.open(map, toBeOpened);';
						unset($_SESSION["votedId"]);
					}

					//open the infowindow after comment redirects
					if (isset($_SESSION["commentId"])) {
						echo 'var availMarkers = oms.getMarkers();';
						echo 'var toBeOpened = $.grep(availMarkers, function(e){ return e.id == "' . $_SESSION["commentId"] . '"; })[0];';
						echo 'iw.setContent(toBeOpened.info);';
						echo 'iw.setOptions({maxWidth: 500});';
						echo 'iw.open(map, toBeOpened);';
						unset($_SESSION["commentId"]);
					}
				?>


			}

		</script>
	</head> 

	<body class="main-page">
		<!--begin navbar-->
		<nav class="navbar navbar-default row">
			<div class="container">
				<div class="navbar-header pull-left">
					<?php
						echo 'Welcome ' . $_SESSION['fullname'];
					?>
				</div>
				<div class="navbar-header pull-right">
					<a class="navbar-brand" href="logout.php"><i title="Logout" class="fa fa-sign-out"></i></a>
				</div>
			</div>
		</nav>
		<!--end navbar-->
		<!--begin loader-->
		<div class="loading" id="page-loading">
			<i class="fa fa-gear fa-spin spin1"></i>
			<i class="fa fa-gear fa-spin spin2"></i>
			<i class="fa fa-gear fa-spin spin3"></i>
		</div>
		<!-- end loader-->
		<!--begin screen container-->
		<div class="container map-holder" id="finished-load">
			<div class="row map-holder">
				<!--begin left panel-->
				<div class="col-md-4 left-panel">
					<!--begin option buttons-->
					<div class="row">
						<div class="row options-panel">
							<div class="options">
								<button class="btn btn-primary" id="trending-show">Trending in your jurisdiction</button>
							</div>
						</div>
					</div>
					<!--end options-->
					<!--begin trending-->
					<div id="trending" class="trending-complaints" style="visibility: visible; height: initial">
						<?php
							$m = new MongoClient();
							$db = $m -> map;
							$collection = $db -> reports;
							if($_SESSION['access'] == "constituency") {
								$cursor = $collection -> find(
									array(
										"constituency" => $_SESSION["constituency"], 
										"taggedAt" => $_SESSION["username"]
									)
								) -> sort(
									array(
										"votes" => (-1)
									)
								) -> limit(10);
							}
							else if($_SESSION['access'] == "district") {
								$cursor = $collection -> find(
									array(
										"district" => $_SESSION["district"]
									)
								) -> sort(
									array(
										"votes" => (-1)
									)
								) -> limit(10);
							}
							else {
								$cursor = $collection -> find() -> sort(
									array(
										"votes" => (-1)
									)
								) -> limit(10);
							}
							foreach ($cursor as $doc) {
								if ($doc["status"] == "open") {
									echo "
										<div class='trending-open-complaint' id='trending-complaint-block-" . $doc["_id"] . "' >\n" . 
									 		$doc["title"] . "\n". 
											"<i id='trending-plus-". $doc["_id"] . "' 
												onClick=openTrendingComplaint('" . $doc["_id"] . "') 
												class='fa fa-plus' style='color: #337AB7;' title='See More'>
											</i><br>\n" .
											"<div class='trending-complaint-info' id='trending-complaint-info-". $doc["_id"] . 
												"'>\n<br>".		
											 	$doc["description"] . "<br><br>\n<strong>Location:&nbsp;</strong>" . 
											 	$doc["location"] . "<br>\n<strong>Tagged at:&nbsp;</strong>" . 
											 	$doc["taggedAt"] . "<br>\n" . 
											    "<strong>Posted on:</strong>&nbsp;" . 
											    date('d-M-Y, H:i', $doc["time"] -> sec ) .
											    "<br>\n" .
											"</div>\n" .
										"</div>" .
										"<hr>" .
										"<br>\n";
								}	
							};
						?>						
					</div>
					<!--end trending-->
				</div>
				<!--end left panel-->
				<!--begin right panel-->
				<div class="col-md-8 map-pane">
					<div id="map"></div>
				</div>
				<!--end right panel-->
			</div>
		</div>
		<!--end screen container-->
		<!--begin mixed js-->
		<script type="text/javascript">
			//Fetch markers from db
			var data = [];
			<?php
				$m = new MongoClient();
				$db = $m -> map;
				$collection = $db -> reports;

				//access controls
				if($_SESSION['access'] == "constituency") {
					$cursor = $collection -> find(
						array(
							"constituency" => $_SESSION["constituency"], 
							"taggedAt" => $_SESSION["username"]
						)
					);
				}
				else if($_SESSION['access'] == "district") {
					$cursor = $collection -> find(
						array(
							"district" => $_SESSION["district"], 
						)
					);
				}
				else {
					$cursor = $collection -> find();
				}

				
				foreach ($cursor as $doc) {
					//display closed complaints also
					if (isset($_GET["closed"])) {
						//varying colors for markers based on number of days since posting
						$currentTime = new DateTime(date('Y-m-d H:i:s'));
						$creationTime = new DateTime(date('Y-m-d H:i:s', $doc["time"] -> sec ));
						$interval = $currentTime -> diff($creationTime);
						$intervalInDays = intval(($interval -> format('%d')));
						
						if ($intervalInDays < 10) {
							$markerColor = "#F7D0C9";
							$animation = 'google.maps.Animation.DROP';
						} 
						else if ($intervalInDays < 20) {
							$markerColor = "#FC8879";
							$animation = 'google.maps.Animation.DROP';
						} 
						else {
							$markerColor = "#FF4241";
							$animation = 'google.maps.Animation.BOUNCE';
						} 

						//  assign markerColor to open complaints
						//  and closed color to closed complaints 
						if ($doc["status"] == "open") {
							echo 'data.push({
									lon:'.$doc["coords"][1].',
									lat: '.$doc["coords"][0].',
									title: "'.$doc["title"] .'",
									html: "'.$doc["description"] .'",
									id: "'.$doc["_id"].'",
									username: "'.$doc["username"].'",
									user: "'.$_SESSION["username"].'",
									votes: '.$doc["votes"].',
									comments: ' . json_encode($doc["comments"]) . ',
									commenters: ' . json_encode($doc["commenters"]) . ',
									taggedAt: "' . $doc["taggedAt"] . '",
									markerColor: "' . $markerColor . '",
									animation: '. $animation . ',
									date: "' . date('d-M-Y, H:i', $doc["time"] -> sec ) . '",
								});
							';
						}
						else {
							echo 'data.push({
									lon:'.$doc["coords"][1].',
									lat: '.$doc["coords"][0].',
									title: "'.$doc["title"] .'",
									html: "'.$doc["description"] .'",
									id: "'.$doc["_id"].'",
									username: "'.$doc["username"].'",
									user: "'.$_SESSION["username"].'",
									votes: '.$doc["votes"].',
									comments: ' . json_encode($doc["comments"]) . ',
									commenters: ' . json_encode($doc["commenters"]) . ',
									taggedAt: "' . $doc["taggedAt"] . '",
									markerColor: "' . '#FFEA9D' . '",
									animation: '. 'google.maps.Animation.DROP' . ',
									date: "' . date('d-M-Y, H:i', $doc["time"] -> sec ) . '",
								});
							';
						}
					}

					else {
						//display only open complaints
						if ($doc["status"] == "open") {
							//varying colors for markers based on number of days since posting
							$currentTime = new DateTime(date('Y-m-d H:i:s'));
							$creationTime = new DateTime(date('Y-m-d H:i:s', $doc["time"] -> sec ));
							$interval = $currentTime -> diff($creationTime);
							$intervalInDays = intval(($interval -> format('%d')));
							if ($intervalInDays < 10) {
								$markerColor = "#F7D0C9";
								$animation = 'google.maps.Animation.DROP';
							} 
							else if ($intervalInDays < 20) {
								$markerColor = "#FC8879";
								$animation = 'google.maps.Animation.DROP';
							} 
							else {
								$markerColor = "#FF4241";
								$animation = 'google.maps.Animation.BOUNCE';
							} 
							echo 'data.push({
									lon:'.$doc["coords"][1].',
									lat: '.$doc["coords"][0].',
									title: "'.$doc["title"] .'",
									html: "'.$doc["description"] .'",
									id: "'.$doc["_id"].'",
									username: "'.$doc["username"].'",
									user: "'.$_SESSION["username"].'",
									votes: '.$doc["votes"].',
									comments: ' . json_encode($doc["comments"]) . ',
									commenters: ' . json_encode($doc["commenters"]) . ',
									taggedAt: "' . $doc["taggedAt"] . '",
									markerColor: "' . $markerColor . '",
									animation: '. $animation . ',
									date: "' . date('d-M-Y, H:i', $doc["time"] -> sec ) . '",
								});
							';
						}
					
					}
					
				}
			?>
			//assign the fetch db data to the map
			window.mapData = data;
		</script>
		<!--end mixed js-->
		<!--begin only JS-->
		<script type="text/javascript" src="js/script.js"></script>
		<!--end only JS-->
		<!--begin form validation-->
		<script> 
				$.validate(); 
				$.formUtils.addValidator({
					name 				: 'normaltext',
					validatorFunction 	: function(value, $el, config, language, $form) {
						return /^[\.\-\/\\1-9a-z\s]+$/i.test(value);
					},
					errorMessage 		: 'Invalid characters present in the entered text.',
					errorMessageKey 	: 'onlyLetters'
				});
		</script>
		<!--end form validation-->
	</body>

</html>
