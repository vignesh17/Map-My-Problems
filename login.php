<?php
    ob_start();
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--http://bootsnipp.com/iframe/W0yg1-->
    <meta charset="utf-8">
    <title>Map My Problems</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
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

<body id="login-signup">
    <script src="http://mymaplist.com/js/vendor/TweenLite.min.js"></script>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="checklogin.php" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" data-validation="length alphanumeric" data-validation-length="min6" placeholder="Username" name="username" type="text">
                            </div>
                            <div class="form-group">
                                <input class="form-control" data-validation="length" data-validation-length="min8" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <div class="form-group">
                                <ul class="login-helper">
                                    <li class="login-helper-content"><a href="forgot.php">Forgot Password?</a></li>
                                    <li class="login-helper-content"><a href="signup.php">Sign Up</a></li>
                                </ul>
                            </div>
                            <div class="form-group text-center" id="spam-error" style="visibility:hidden;height:0;">
                                <label class="login-error">You have been logged out for spamming. Repeating this will result in banning of your account.</label>
                            </div>
                            <?php
                                if ($_SESSION['reset'] == 1) {
                                    echo '
                                        <div class="form-group text-center">
                                            <label class="login-error">Password has been reset successfully.</label>
                                        </div>
                                    ';
                                }
                                if (isset($_SESSION['locked'])) {
                                    echo '
                                        <div class="form-group text-center">
                                            <label class="login-error">Your IP address has been flagged for suspicious activity. You have been temporarily banned.</label>
                                        </div>
                                    ';
                                }
                                if (isset($_SESSION['spam'])) {
                                    echo '
                                        <div class="form-group text-center">
                                            <label class="login-error">You have been logged out for spamming. Repeating this will result in banning of your account.</label>
                                        </div>
                                    ';
                                }
                                if (isset($_SESSION['login-error'])) {
                                    if ($_SESSION['login-error'] == 1) {
                                        echo '
                                            <div class="form-group text-center">
                                                <label class="login-error">Invalid credentials. Try again.</label>
                                            </div>
                                        ';
                                    }
                                    elseif ($_SESSION['login-error'] == 3) {
                                        echo '
                                            <div class="form-group text-center">
                                                <label class="login-error">Check your mail for activation link.</label>
                                            </div>
                                        ';
                                    }
                                    else {
                                        echo '
                                            <div class="form-group text-center">
                                                <label class="login-error">Please prove that you are human.</label>
                                            </div>
                                        ';
                                    }
                                }
                                session_destroy();
                            ?>
                            <div style="text-align: -webkit-center;margin-bottom: 10px;" class="g-recaptcha" data-theme="dark" data-sitekey="6LcbKhETAAAAAG0qN3ebzmdKFqTMCDJI8gv4GWyo"></div>
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
                        </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    $(document).ready(function(){
        if (sessionStorage.spam == '1') {
            var spamMessage = document.getElementById('spam-error');
            console.log("asdad");
            console.log(sessionStorage.spam);
            console.log(spamMessage.visibility);
            spamMessage.style.visibility = "visible";
            spamMessage.style.height = "initial";
            sessionStorage.spam = 0;
            alert('js');
        }
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
    <script> $.validate(); </script>
</body>
</html>
