
<!DOCTYPE html>
<html lang="en">
<head>
    <!--http://bootsnipp.com/iframe/W0yg1-->
    <meta charset="utf-8">
    <title>Map My Problems</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <style type="text/css">
    .panel-title {
    margin-top: 0;
    margin-bottom: 0;
    font-size: 16px;
    color: white;
    /* background-color: #F0AF3B; */
    font-weight: 900;
}
.panel-default {
    /* border-color: #ddd; */
    background-color: #2f2f2f;
}
.panel-default>.panel-heading {
    color: #333;
    background-color: #FF9933;
    /* border-color: #ddd; */
}
.panel-default {
    border: none;
    margin-top: 40%;
}
.panel-heading {
    border: none;
}
    body{
    background: url(http://mymaplist.com/img/parallax/back.png);
	background-color: #444;
    background: url(http://mymaplist.com/img/parallax/pinlayer2.png),url(http://mymaplist.com/img/parallax/pinlayer1.png),url(http://mymaplist.com/img/parallax/back.png);    
}

.vertical-offset-100{
    padding-top:100px;
}
    </style>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        window.alert = function(){};
        var defaultCSS = document.getElementById('bootstrap-css');
        function changeCSS(css){
            if(css) $('head > link').filter(':first').replaceWith('<link rel="stylesheet" href="'+ css +'" type="text/css" />'); 
            else $('head > link').filter(':first').replaceWith(defaultCSS); 
        }
        $( document ).ready(function() {
          var iframe_height = parseInt($('html').height()); 
          window.parent.postMessage( iframe_height, 'http://bootsnipp.com');
        });
    </script>
</head>
<body>
	<script src="http://mymaplist.com/js/vendor/TweenLite.min.js"></script>
<!-- This is a very simple parallax effect achieved by simple CSS 3 multiple backgrounds, made by http://twitter.com/msurguy -->

<div class="container">
    <div class="row">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Sign Up</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form accept-charset="UTF-8" role="form">
                    <fieldset> 
                        <div class="form-group">
                            <input class="form-control" placeholder="Name" name="name" type="text">
                        </div>
			    	  	<div class="form-group">
			    		    <input class="form-control" placeholder="Username" name="username" type="text">
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Password" name="password" type="password" value="">
			    		</div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Confirm Password" name="cpassword" type="password" value="">
                        </div>
			    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Sign Up">
			    	</fieldset>
			      	</form>
			    </div>
			</div>
		</div>
	</div>
</div>
	<script type="text/javascript">
	$(document).ready(function(){
  $(document).mousemove(function(e){
     TweenLite.to($('body'), 
        .5, 
        { css: 
            {
                backgroundPosition: ""+ parseInt(event.pageX/8) + "px "+parseInt(event.pageY/'12')+"px, "+parseInt(event.pageX/'15')+"px "+parseInt(event.pageY/'15')+"px, "+parseInt(event.pageX/'30')+"px "+parseInt(event.pageY/'30')+"px"
            }
        });
  });
});
	</script>
</body>
</html>
