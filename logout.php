<?php
if ($_SESSION["MANAGER_ID"] == "") {
    $_SESSION["logout"] = "You are not logged in, therefore you cannot logout!";
    header("location:index.php");
}
?>
<?php
session_unset();
session_destroy();
session_start();
$_SESSION['ERROR'] = 'You have been logged out';
$_SESSION['MANAGER_ID'] = '';
header("location:index.php");
exit();
