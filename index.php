
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
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html">Map My Problems</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav pull-right">
          <li><a href="about.html">About</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container map-holder">
    <div class="row map-holder">
      <div class="col-md-4">
        <form accept-charset="UTF-8" role="form">
          <fieldset>
            <div class="form-group">
              <input class="form-control" placeholder="Complaint Title" name="title" type="text">
            </div>
            <div class="form-group">
              <textarea class="form-control" name="description" placeholder="Complaint Description" rows="4"></textarea>
            </div>
            <div class="form-group">
              <input class="form-control" placeholder="Location" name="location" type="text">
            </div>
            <input class="btn btn-lg btn-success btn-block" type="submit" value="Submit">
          </fieldset>
        </form>
      </div>
      <div class="col-md-8 map-pane">
        <div id="map"></div>
      </div>
    </div>
  </div>
  <script src="js/map.js"></script>
  <script async defer
        src="https://maps.googleapis.com/maps/api/js?signed_in=true&callback=initMap"></script>
  </body>
</html>
