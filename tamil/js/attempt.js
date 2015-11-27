
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
							info: "<h4 class='report-title'>"+datum.title+"</h4><h5>Tagged at: "+datum.taggedAt+"</h5><br><h6>Currently voted by "+datum.votes+" people<br><br><a href='vote.php?vote=up&id="+datum.id+'&user='+datum.user+"'>"+"Vote Up</a>"+"\n"+"&nbsp;&nbsp;&nbsp;<a href='vote.php?vote=down&id="+datum.id+'&user='+datum.user+"'>"+"Vote Down</a>"+"\n"+"<br><br><br><p class='report-desc'>"+datum.html+"</p><br><h5>Comments</h5>"+comments+"<br><form class='form-group' method='post' action='comment.php?id="+datum.id+'&user='+datum.user+"'><div><input class='form-control' type=text name='comment'></div><br><input class='btn btn-success btn-block' type='submit' value='Post Comment'>"
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
							info: "<h4 class='report-title'>"+datum.title+"</h4><h5>Tagged at: "+datum.taggedAt+"</h5><br><h6>Currently voted by "+datum.votes+" people<br><br><a href='vote.php?vote=up&id="+datum.id+'&user='+datum.user+"'>"+"Vote Up</a>"+"\n"+"&nbsp;&nbsp;&nbsp;<a href='vote.php?vote=down&id="+datum.id+'&user='+datum.user+"'>"+"Vote Down</a>"+"\n"+"<br><br><br><p class='report-desc'>"+datum.html+"</p><br><h5>Comments</h5>"+comments+"<br><form class='form-group' method='post' action='comment.php?id="+datum.id+'&user='+datum.user+"'><div><input class='form-control' type=text name='comment'></div><br><input class='btn btn-success btn-block' type='submit' value='Post Comment'>"
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