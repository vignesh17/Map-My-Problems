<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <title>#ChennaiFloods2015</title>
        <script src="js/jquery.js"></script>
        
        <script src="js/markerclusterer.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/spider.js"></script>
        <script>

            //Convert location to coordinates
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                coords = [];
                coords.push(place.geometry.location.lat());
                coords.push(place.geometry.location.lng());
            })

            $(function() {

                $("#submit-button").click(function() {

                    var type = $("#type").val();
                    var details = $("#details").val();
                    var person = $("#person").val();
                    var contact = $("#contact").val();
                    var location = $("#pac-input").val();
                    var taggedAt = $("#taggedAt").val();
                    var dataString = {'type': type, 'details': details, 'person': person, 'coords': coords, 'contact': contact};
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

                                document.getElementById('type').value = '';
                                document.getElementById('details').value = '';
                                document.getElementById('person').value = '';
                                document.getElementById('contact').value = '';
                                document.getElementById('pac-input').value = '';
                                document.getElementById('insert-successful').innerHTML = 'Your request has been successfully submitted.';

                            }
                        });
                    }

                });
            });
        </script>
        <style type="text/css">
            #form{
                padding: .5em .6em;
                display: inline-block;
                vertical-align: middle;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            input, textarea {
                margin-bottom: 10px;
                width: 380px;
                margin-top: 10px;
                height: 35px;
            }

        </style>
    </head> 
    <body class="main-page">
        <form id="form" action="" method="post" name="form">    
            <div>
                <label>Type of help needed</label>
                <select name="type" id="type">
                    <option value="rescue">Rescue</option>
                    <option value="food">Food</option>
                    <option value="clothing">Clothing</option>
                    <option value="medical">Medical Emergency</option>
                </select>
            </div>
            <div>
                <textarea cols="45"   placeholder="Details" name="details" id="details" type="text"></textarea>
            </div>
            <div>
                <input  name="person" id="person" placeholder="Your name">
            </div>
            <div>
                <input  name="contact" id="contact" placeholder="Your contact number">
            </div>
            <div>
                <input id="pac-input" placeholder="Please give an accurate location with street names if possible." name="location" type="text">
            </div>
            <input type="button" id="submit-button" value="Submit">  
        </form>
        <div id="insert-successful" class="text-center">
        </div>
    </body>
</html>
