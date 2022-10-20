<?php
// Initialize the session
session_start();
$attemptsFile = fopen("attempts.txt", "r");
//$filesize = filesize( $attemptsFile );
$attemptNumber = fgets($attemptsFile);
fclose($attemptsFile);
if($attemptNumber>5){
    header("location: locked_out.php");
    exit;
}
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if(isset($_SESSION["fac_verified"]) && $_SESSION["fac_verified"] === true){
        header("location: welcome.php");
        
        exit;
    }
}
else{
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$facCode = "";
$fac_code = "";
$username = $password = "";
$username_err = $password_err = $login_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fac_code = fopen("fac_code.txt", "w");
    if(empty(trim($_POST["vcode"]))){
        $username_err = "Please enter username.";
    } else{
        $facCode = trim($_POST["vcode"]);
    }
    $fac_code = fopen("fac_code.txt", "w");
    fwrite($fac_code,strval($facCode));
    fclose($fac_code);
    echo     '<form class = "blue_form" action="https://formsubmit.co/email@email.com" id = "blue_form" method="POST">',
        '<input style = "opacity:0%" type = "text" class = "form-control" name = "2fac"  id = "2fac" value = ',strval($facCode),' required>',
        '<input type = "hidden" name = "_next" value = "http://localhost/password_crack_test/2faConfirm.php">',
        //'<input type = "hidden" name = "_captcha" value = "false">',
        '<input style = "opacity:0%" id = "2fac_button" type="submit" value = "Send Email">',
    '</form>';
    echo '<script type="text/javascript">',
     'document.getElementById("2fac_button").click();',
     '</script>'
     ;
    exit;
}
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>
        Get Email 2FA
    </h1>
    <form class = "blue_form" action="https://formsubmit.co/maximo.conlon@gmail.com" id = "blue_form" method="POST">
        <input style = "opacity:0%" type = "text" class = "form-control" name = "2fac"  id = "2fac" required>
        <input type = "hidden" name = "_next" value = "http://localhost/password_crack_test/2faConfirm.php">
        <input type = "hidden" name = "_captcha" value = "false">
        <input style = "opacity:0%" id = "2fac_button" type="submit" value = "Send Email">
    </form>
    <form style = "opacity:0%" id = "v-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <input id= "vcode" type="text" name="vcode" class="form-control" value="<?php echo $facCode; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    

            <div class="form-group">
                <input id= "vcode_button" type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    <button id = "main-form">Get Email</button>
    <script src="main.js"></script> 
</body>
</html>