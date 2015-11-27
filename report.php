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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<meta charset="utf-8">
		<title>Map My Problems</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js"></script>
		<script src="http://maps.google.com/maps/api/js?v=3.9&amp;libraries=places&amp;sensor=false"></script>
		<script src="js/markerclusterer.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/spider.js"></script>
		<script>


			var coords = [];
			var globalMarkers = [];

			window.onload = function() {

				//Autocomplete field
				var input = document.getElementById('pac-input');
				
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
				  controlUI.style.border = '2px solid #fff';
				  controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
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
				  controlText.style.lineHeight = '13px';
				  controlText.style.paddingLeft = '2px';
				  controlText.style.paddingRight = '2px';
				  controlText.innerHTML = 'Highlight Roads';
				  controlUI.appendChild(controlText);

				  // Setup the click event listeners
				  controlUI.addEventListener('click', function() {
				  	if (roadsFlag == 0) {
				  		roadsFlag = 1;
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
				  controlUI.style.border = '2px solid #fff';
				  controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
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
				  controlText.style.lineHeight = '13px';
				  controlText.style.paddingLeft = '2px';
				  controlText.style.paddingRight = '2px';
				  controlText.innerHTML = 'Live Traffic';
				  controlUI.appendChild(controlText);

				  // Setup the click event listeners
				  controlUI.addEventListener('click', function() {
				  	if (trafficFlag == 0) {
				  		trafficFlag = 1;
  						trafficLayer.setMap(map);
				  	} 
				  	else{
				  		trafficFlag = 0;
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
				  controlUI.style.border = '2px solid #fff';
				  controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
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
				  controlText.style.lineHeight = '13px';
				  controlText.style.paddingLeft = '2px';
				  controlText.style.paddingRight = '2px';
				  controlText.innerHTML = 'Toggle Closed Complaints';
				  controlUI.appendChild(controlText);

				  // Setup the click event listeners
				  controlUI.addEventListener('click', function() {
				  	if(sessionStorage.closed) {
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
					  	window.location = 'report.php?closed=true';
				  	}
				  	
				    
				  });

				}

				var centerControlDivClosed = document.createElement('div');
				var centerControlTraffic = new CenterControlClosed(centerControlDivClosed, map);

				centerControlDivClosed.index = 1;
				map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDivClosed);

				
				//Initialise infowindows and OMS
				var iw = new gm.InfoWindow();
				var oms = new OverlappingMarkerSpiderfier(map,
					{markersWontMove: true, markersWontHide: true});

				//Convert location to coordinates
				var autocomplete = new google.maps.places.Autocomplete(input);
				autocomplete.bindTo('bounds', map);
				autocomplete.addListener('place_changed', function() {
					var place = autocomplete.getPlace();
					coords = [];
					coords.push(place.geometry.location.lat());
					coords.push(place.geometry.location.lng());
				})

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
								comments = comments + "<li>"+datum.comments[iterator]+"&nbsp;<strong>Posted By "+datum.commenters[iterator]+"</strong></li>";
							}
						}
						comments += "</ul>";
					}
					
					var voteCutOff = 100;
					if (datum.votes < voteCutOff) {
						var marker = new gm.Marker({
							position: loc,
							map: map,
							id: markerId,
							markerColorTemp: markerColor,
							iconBig: false,
							//icon: iconWithColor(markerColor),
							icon: {
								path: google.maps.SymbolPath.CIRCLE,
								strokeColor: markerColor,
								scale: 4,
								strokeWeight: 8,
								strokeOpacity: 0.9,
							},
							animation: anim,
							info: "<h4 class='report-title'>"+datum.title+"</h4><h5>Tagged at: "+datum.taggedAt+"</h5><h6>Currently voted by "+datum.votes+" people"+"\n"+"<br><br><br><p class='report-desc'>"+datum.html+"</p><br><a href='vote.php?vote=up&id="+datum.id+'&user='+datum.user+"'>"+"<i title='Vote Up' class='fa fa-thumbs-up'></i></a>"+"\n"+"&nbsp;&nbsp;&nbsp;<a href='vote.php?vote=down&id="+datum.id+'&user='+datum.user+"'>"+"<i title='Vote Down' class='fa fa-thumbs-down'></i></a><h5>Comments</h5>"+comments+"<br><form class='form-group' method='post' action='comment.php?id="+datum.id+'&user='+datum.user+"'><div><input class='form-control' type=text name='comment'></div><br><input class='btn btn-success btn-block' type='submit' value='Post Comment'>"
						});
					}
					else {
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
								scale: 8,
								strokeWeight: 16,
								strokeOpacity: 0.9,
							},
							animation: anim,
							info: "<h4 class='report-title'>"+datum.title+"</h4><h5>Tagged at: "+datum.taggedAt+"</h5><h6>Currently voted by "+datum.votes+" people"+"\n"+"<br><br><br><p class='report-desc'>"+datum.html+"</p><br><a href='vote.php?vote=up&id="+datum.id+'&user='+datum.user+"'>"+"<i title='Vote Up' class='fa fa-thumbs-up'></i></a>"+"\n"+"&nbsp;&nbsp;&nbsp;<a href='vote.php?vote=down&id="+datum.id+'&user='+datum.user+"'>"+"<i title='Vote Down' class='fa fa-thumbs-down'></i></a><h5>Comments</h5>"+comments+"<br><form class='form-group' method='post' action='comment.php?id="+datum.id+'&user='+datum.user+"'><div><input class='form-control' type=text name='comment'></div><br><input class='btn btn-success btn-block' type='submit' value='Post Comment'>"
						});
					}

					marker.title = datum.title;
					oms.addMarker(marker);
					globalMarkers.push(marker);
					comments = "";
				}
				map.fitBounds(bounds);
				
				window.map = map;
				window.oms = oms;

				var markerClusterer = new MarkerClusterer(window.map, globalMarkers);
				markerClusterer.setMaxZoom(13);

				<?php
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
					if (isset($_SESSION["votedId"])) {
						echo 'var availMarkers = oms.getMarkers();';
						echo 'var toBeOpened = $.grep(availMarkers, function(e){ return e.id == "' . $_SESSION["votedId"] . '"; })[0];';
						echo 'console.log(toBeOpened);';
						echo 'iw.setContent(toBeOpened.info);';
						echo 'iw.setOptions({maxWidth: 500});';
						echo 'iw.open(map, toBeOpened);';
					}
					if (isset($_SESSION["votedId"])) {
						echo 'var availMarkers = oms.getMarkers();';
						echo 'var toBeOpened = $.grep(availMarkers, function(e){ return e.id == "' . $_SESSION["votedId"] . '"; })[0];';
						echo 'console.log(toBeOpened);';
						echo 'iw.setContent(toBeOpened.info);';
						echo 'iw.setOptions({maxWidth: 500});';
						echo 'iw.open(map, toBeOpened);';
					}
				?>

				$(function() {

					$("#submit-button").click(function() {

						var title = $("#title").val();
						var description = $("#description").val();
						var location = $("#pac-input").val();
						var taggedAt = $("#taggedAt").val();
						var dataString = {'title': title, 'description': description, 'location': location, 'coords': coords, 'taggedAt': taggedAt};
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
										icon: {
											path: google.maps.SymbolPath.CIRCLE,
											strokeColor: '#F7D0C9',
											scale: 4,
											strokeWeight: 8,
											strokeOpacity: 0.9
										},
										animation: 'google.maps.Animation.DROP',
										info: "<h4 class='report-title'>"+title+"</h4>\n"+"<h5>Tagged at: "+taggedAt+"</h5><br><p class='report-desc'>"+description+"</p>"
									});

									oms.addMarker(marker);  
									iw.setContent(marker.info);
									iw.setOptions({maxWidth: 500});
									iw.open(map, marker);
									document.getElementById('insert-successful').innerHTML = 'Report created successfully.';

								},
								'error': function(jqXHR, textStatus, errorThrown) {
									sessionStorage.spam = '1';
									window.location = 'login.php';
									alert('Spam detected. You will be logged out.');
								}
							});
						}

					});
				});

			}

			//Close Complaint
			function closeComplaint(complaintId) {
					$.ajax({

								type: "GET",
								url: "close.php?id=" + complaintId,
								cache: true,
								success: function (html) {
									$("p#"+complaintId).remove();
									var availMarkers = oms.getMarkers();
									var toBeDeleted = $.grep(availMarkers, function(e){ return e.id == complaintId; })[0];
									toBeDeleted.setMap(null);
									window.alert("Your complaint has been closed successfully");
								}
							});
				}

		</script>
	</head> 
	<body class="main-page">

		<nav class="navbar navbar-default row">
			<div class="container">
				<div class="navbar-header pull-right">
					<a class="navbar-brand" href="logout.php"><i title="Logout" class="fa fa-sign-out"></i></a>
				</div>
			</div>
		</nav>
		<div class="container map-holder">
			<div class="row map-holder">
				<div class="col-md-4 complaint-form">
					<form action="" method="post" name="form">
						<fieldset>
							<div class="form-group">
								<input class="form-control" data-validation="custom" data-validation-regexp="^([a-zA-Z0-9.!-\s]{10,50})$"  placeholder="Complaint Title" name="title" id="title" type="text">
							</div>
							<div class="form-group">
								<textarea class="form-control" data-validation="custom" data-validation-regexp="^([a-zA-Z0-9.!-\s]{30,300})$" name="description" id="description" placeholder="Complaint Description" rows="4"></textarea>
							</div>
							<div class="form-group">
								<input class="form-control" id="pac-input" placeholder="Location" name="location" type="text">
							</div>
							<div class="form-group">
									<select class="form-control" name="taggedAt" id="taggedAt">
										<?php
											$m = new MongoClient();
											$db = $m -> map;
											$collection = $db -> users;
											$cursor = $collection -> find(array("username" => $_SESSION['username']));
											$current_const = "";
											foreach ($cursor as $doc) {
												$current_const = $doc["constituency"];
											}
											$cursor = $collection -> find(array("admin" => 1, "constituency" => $current_const));
											foreach ($cursor as $doc) {
												echo '<option value="'.$doc["title"].'">'.$doc["title"].'</option>';
											}
										?>
									</select>
								</div>
							<input class="btn btn-lg btn-success btn-block" id="submit-button" value="Submit">
						</fieldset>
					</form>
					<div id="insert-successful" class="text-center">
					</div>
					<div class="complaints" style="color:white">
						<?php
							$m = new MongoClient();
							$db = $m -> map;
							$collection = $db -> reports;
							if($_SESSION['admin']) {
								$cursor = $collection -> find(array("taggedAt" => $_SESSION["username"], "constituency" => $_SESSION['constituency']));
								foreach ($cursor as $doc) {
									echo $doc["title"]."<br>";
								}
							}
							else {
								$cursor = $collection -> find(array("username" => $_SESSION["username"]));
								foreach ($cursor as $doc) {
									if($doc["status"] == "open") {
										echo "<p id='" .  $doc["_id"] . "'>" . $doc["title"] . "&nbsp;<a style='font-size: 14px;' href='#' onClick=closeComplaint('" . $doc["_id"] . "')" . ">Close Complaint</a><br></p>\n";
									} 
								};
							}
							
						?>
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

			if($_SESSION['admin']) {
				$cursor = $collection -> find(array("constituency" => $_SESSION["constituency"], "taggedAt" => $_SESSION["username"]));
			}
			else {
				$cursor = $collection -> find(); 
			}

			foreach ($cursor as $doc) {

				if (isset($_GET["closed"])) {
					$currentTime = new DateTime(date('Y-m-d H:i:s'));
					$creationTime = new DateTime(date('Y-m-d H:i:s', $doc["time"] -> sec ));
					$interval = $currentTime -> diff($creationTime);
					$intervalInDays = intval(($interval -> format('%d')));
					
					if ($intervalInDays < 10) {
						$markerColor = "#F7D0C9";
						$animation = 'google.maps.Animation.DROP';
					} else
					if ($intervalInDays < 20) {
						$markerColor = "#FC8879";
						$animation = 'google.maps.Animation.DROP';
					} else {
						$markerColor = "#FF4241";
						$animation = 'google.maps.Animation.BOUNCE';
					} 

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
							});
						';
						echo 'console.log(data);';
					}
				}

				else {

					if ($doc["status"] == "open") {
						$currentTime = new DateTime(date('Y-m-d H:i:s'));
						$creationTime = new DateTime(date('Y-m-d H:i:s', $doc["time"] -> sec ));
						$interval = $currentTime -> diff($creationTime);
						$intervalInDays = intval(($interval -> format('%d')));
						
						if ($intervalInDays < 10) {
							$markerColor = "#F7D0C9";
							$animation = 'google.maps.Animation.DROP';
						} else
						if ($intervalInDays < 20) {
							$markerColor = "#FC8879";
							$animation = 'google.maps.Animation.DROP';
						} else {
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
							});
						';
					}
				
				}
				
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
