<?php
ob_start();
session_start();

include "./INCLUDES/db.php";
// include "./includes/functions.js";

if (isset($_SESSION["MANAGER_ID"])) {

} else {
    $_SESSION["MANAGER_ID"] = "";
}
if (isset($_SESSION["ERROR"])) {

} else {
    $_SESSION["ERROR"] = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script data-ad-client="ca-pub-7627390993876067" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="./img/logo.ico" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/64b5f0be18.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="CSS/styles.css">
    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <script>
    $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            $(".1").toggle();
        });
    });
    </script>
    <title>Expo Evaluator</title>
</head>
<body>
    <div class="wrapper">
    <!-- navigation -->
    <div class="logo">
        <h1 class="ml1">
            <span class="text-wrapper">
              <span class="line line1" style="background-color: var(--dark);"></span>
              <span class="letters" style="color: var(--dark);">Expo Evaluator</span>
              <span class="line line2" style="background-color: var(--dark);"></span>
            </span>
          </h1>
    </div>
    <div class="main-nav">
        <ul>
            <!-- <li><a href="./login.php">Login</a></li>
            <li><a href="./register.php">Register</a></li>
            <li><a href="./wos.php">Wall of Shame</a></li> -->
            <?php
if ($_SESSION["MANAGER_ID"] == "") {
    echo "<li><a href='./index.php'>Home</a></li>";
    echo "<li><a href='./login.php'>Login</a></li>";
    echo "<li><a href='./join.php'>Find an Event</a></li>";
} elseif ($_SESSION["MANAGER_ID"] != "") {
    echo "<li><a href='./manager-panel.php'>Manager Panel</a></li>";
    echo "<li><a href='./join.php'>Find an Event</a></li>";
    echo "<li><a href='./logout.php'>Logout</a></li>";
}

?>
        </ul>
    </div>
    <?php
if ($_SESSION["ERROR"] == "") {

} else {
    $message = $_SESSION["ERROR"];
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
  $message
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
}
?>