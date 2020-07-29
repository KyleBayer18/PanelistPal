<?php
    include "./header.php";
    if($_SESSION["MANAGER_ID"] == ""){
        $_SESSION["ERROR"] = "You need to be a manager to view this page.";
        header("location:./index.php");
    }elseif($_SESSION["MANAGER_ID"] != ""){
        $id = $_SESSION["MANAGER_ID"];

        $conn = db_connect();

        $sql = "SELECT * FROM event_managers WHERE event_manager_id = '$id'";

        $results = pg_query($conn, $sql);

        while($row = pg_fetch_assoc($results)){
            $verified = $row["email_verified_at"];

            if($verified == null){
                header("location:./verify.php");
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $conn = db_connect();

        if(isset($_GET["enable"])){

            $id = $_GET["enable"];

            $sql = "UPDATE events SET is_active = 'TRUE' WHERE event_id = '$id'";

            $results = pg_query($conn, $sql);

            if(!$results){
                $_SESSION["ERROR"] = "Event could not be updated!";
            }else{
                $_SEESION["ERROR"] = "Your event has been set to enabled";
                header("location:./manager-panel.php");
            }

        }else{

            if(isset($_GET["disable"])){

                $id = $_GET["disable"];

                $sql = "UPDATE events SET is_active = 'FALSE' WHERE event_id = '$id'";

                $results = pg_query($conn, $sql);

                if(!$results){
                    $_SESSION["ERROR"] = "Event could not be updated!";
                }else{
                    $_SEESION["ERROR"] = "Your event has been set to disabled";
                    header("location:./manager-panel.php");
                }

            }else{

                if(isset($_GET["delete"])){

                    $id = $_GET["delete"];
                    
                    $sql = "DELETE FROM events WHERE event_id = '$id'";
                    
                    $results = pg_query($conn, $sql);
                    
                    if(!$results){
                        $_SESSION["ERROR"] = "Event could not be deleted!";
                    }else{
                        $_SEESION["ERROR"] = "Your event has been deleted!";
                        header("location:./manager-panel.php");
                    }
                }

            }

        }

    } 
?>

<?php
    include "./footer.php";
?>