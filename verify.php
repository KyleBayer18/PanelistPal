<?php
include "./header.php";


if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    
    if(!isset($_SESSION["MANAGER_ID"]) || $_SESSION["MANAGER_ID"] == ""){
        header("location:./login.php");
    }
    if(isset($_GET["id"])){
        $id = $_GET["id"];

        $conn = db_connect();

        $sql = "SELECT * FROM event_managers WHERE event_manager_id = '$id'";

        $results = pg_query($conn, $sql);

        if(!$results){
            $_SESSION["ERROR"] = "There was an error getting your information!";
        }else{
            while($row = pg_fetch_assoc($results)){
                $email = $row["email"];
                $hash = $row["hash"];

                $to = $email;

                $subject = 'Expo Evaluator - Email Verification';

                $message = 'Enter the following code to verify your account: ';
                
                $message .= $hash;

                $header = 'From: no-reply@expo.com';

                $a = mail($to, $subject, $message, $header);

                if($a){
                    $_SESSION["ERROR"] = "EMAIL SENT";
                    // ECHO "EMAIL SENT";
                }else{
                    $_SESSION["ERROR"] = "EMAIL NOT SENT";
                    // ECHO "EMAIL NOT SENT";
                }
            }
        }
    }
    $conn = db_connect();

    $email = $_SESSION["USERNAME"];

    $sql = "SELECT * FROM event_managers WHERE email = '$email'";

    $results = pg_query($conn, $sql);

    if(!$results){

    }

    while($row = pg_fetch_assoc($results)){
        $verified = $row["email_verified_at"];

        if($verified != null){
            header("location:./manager-panel.php");
        }
    }
    
}
else if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $conn = db_connect();
    $_SESSION["ERROR"] = "";
    $code = trim($_POST["verify"]);
    $id = $_SESSION["MANAGER_ID"];
    $sql = "SELECT * FROM event_managers WHERE event_manager_id = '$id'";
    $results = pg_query($conn, $sql);
    if (pg_num_rows($results) != 0)
    { //not zero means something was found
        
        while ($row = pg_fetch_assoc($results))
        {
            $hash = $row["hash"];

            if($code == $hash)
            {
                echo "CODE: $code HASH: $hash";
                $conn = db_connect();
                
                $date = date("Y-m-d");

                $sql = "UPDATE event_managers SET email_verified_at = '$date' WHERE event_manager_id = '$id'";

                $result = pg_query($conn, $sql);

                if(!$result){
                    $_SESSION["ERROR"] .= "There was an error updating the validity of your account!";
                }

                if($_SESSION["ERROR"] == ""){
                    header("location:./manager-panel.php");
                }
            }

        }

    }
    else
    {
        $_SESSION['ERROR'] = "The code you entered did not match!";
    }
}

?>
<p><?php 
    $error = $_SESSION["ERROR"];
    $email = $_SESSION["USERNAME"];
    if($error == ""){
        $_SESSION["ERROR"] = "The verification code was sent to $email";
    }else{
        $_SESSION["ERROR"] = "$error";
    }
?>
    <section class="login">
    <div class="box">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" align="center">
        <h2 class="text-center">Verify Account</h2>    
        <br>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Verification Code" name="verify">
        </div>
        <!-- <div class="form-group">
            <input type="password" class="form-control" placeholder="password" required="required" name="password">
        </div> -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Verify</button>
        </div>
        <div class="form-group">
            <?php 
                $id = $_SESSION["MANAGER_ID"];
                echo "<a href='./verify.php?id=$id'>Resend Email</a>";
            ?>
        </div>
    </form>
    </div>
    </section>


<?php
include "./footer.php";
?>
