//Left pane options
$('#complaints-create').click(function() {
	$('#new-complaint').css({
		visibility 	: 'visible',
		height 		: 'initial'
	});
	$('#my-complaints').css({
		visibility 	: 'hidden',
		height 		: '0'
	});
	$('#trending').css({
		visibility 	: 'hidden',
		height 		: '0'
	});
});

$('#complaints-show').click(function() {
	$('#my-complaints').css({
		visibility 	: 'visible',
		height 		: '540px'
	});
	$('#new-complaint').css({
		visibility 	: 'hidden',
		height 		: '0'
	});
	$('#trending').css({
		visibility 	: 'hidden',
		height 		: '0'
	});
});

$('#trending-show').click(function() {
	$('#trending').css({
		visibility 	: 'visible',
		height 		: 'initial'
	});
	$('#my-complaints').css({
		visibility 	: 'hidden',
		height 		: '0'
	});
	$('#new-complaint').css({
		visibility 	: 'hidden',
		height 		: '0'
	});
});

//  hold infowindows with id as key so that they
//  can be closed when some other window is opened.
var infoWindows = [];

function openComplaint(id) {
	var complaintId = '#complaint-info-' + id;
	$(complaintId).css({
		visibility 	: 'visible',
		height 		: 'initial',

	});
	//replace plus with minus
	var plusId = '#plus-' + id;
	$(plusId).attr('class', 'fa fa-minus');
	var func = "hideComplaint('" + id + "')"
	$(plusId).attr('onClick', func);
	//open infowindow
	var availMarkers = oms.getMarkers();
	var toOpen = $.grep(availMarkers, function(e){ return e.id == id; })[0];
	map.setCenter(toOpen['position']);
	infoWindows[id] = new google.maps.InfoWindow();
	infoWindows[id].setContent(toOpen.info);
	infoWindows[id].setOptions({maxWidth: 500});
	infoWindows[id].open(map, toOpen);
}

function hideComplaint(id) {
	var complaintId = '#complaint-info-' + id;
	$(complaintId).css({
		visibility 	: 'hidden',
		height 		: '0'
	});
	//replace plus with minus
	var plusId = '#plus-' + id;
	$(plusId).attr('class', 'fa fa-plus');
	var func = "openComplaint('" + id + "')"
	$(plusId).attr('onClick', func);
	//close open infowindow
	infoWindows[id].close();
}

//  hold infowindows with id as key so that they
//  can be closed when some other window is opened.
var infoTrendingWindows = [];

function openTrendingComplaint(id) {
	var complaintId = '#trending-complaint-info-' + id;
	$(complaintId).css({
		visibility 	: 'visible',
		height 		: 'initial',
		
	});
	//replace plus with minus
	var plusId = '#trending-plus-' + id;
	$(plusId).attr('class', 'fa fa-minus');
	var func = "hideTrendingComplaint('" + id + "')"
	$(plusId).attr('onClick', func);
	//open infowindow
	var availMarkers = oms.getMarkers();
	var toOpen = $.grep(availMarkers, function(e){ return e.id == id; })[0];
	map.setCenter(toOpen['position']);
	infoTrendingWindows[id] = new google.maps.InfoWindow();
	infoTrendingWindows[id].setContent(toOpen.info);
	infoTrendingWindows[id].setOptions({maxWidth: 500});
	infoTrendingWindows[id].open(map, toOpen);
}

function hideTrendingComplaint(id) {
	var complaintId = '#trending-complaint-info-' + id;
	$(complaintId).css({
		visibility 	: 'hidden',
		height 		: '0'
	});
	//replace plus with minus
	var plusId = '#trending-plus-' + id;
	$(plusId).attr('class', 'fa fa-plus');
	var func = "openTrendingComplaint('" + id + "')"
	$(plusId).attr('onClick', func);
	//close open infowindow
	infoTrendingWindows[id].close();
}