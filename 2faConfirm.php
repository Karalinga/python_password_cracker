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
$vcode = "";
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["2fac"]))){
        $username_err = "Please enter username.";
    } else{
        $facCode = trim($_POST["2fac"]);
    }
    $vcode = strval(fgets(fopen("fac_code.txt","r")));
    
    if($facCode === $vcode){
        header("location: welcome.php");
        exit;
    }
    exit;
}
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form id = "main-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Enter Code</label>
                <input  type="text" name="2fac" class="form-control" value="<?php echo $facCode; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
    
</body>
</html>