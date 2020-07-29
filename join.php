<?php
include "./header.php";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $name = "";
    $eventCode = "";
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["ERROR"] = "";
    $name = trim($_POST["name"]);
    $eventCode = trim($_POST["eventCode"]);
    $conn = db_connect();
    $sql = "SELECT event_id, event_code, is_active FROM
        events WHERE event_code = '$eventCode'";
    $results = pg_query($conn, $sql);
    if (pg_num_rows($results) != 0) { //not zero means something was found
        while ($row = pg_fetch_assoc($results)) {
            $eventCode = $row["event_code"];
            setcookie("event_code", "$eventCode", time() + 2 * 24 * 60 * 60);
            $eventID = $row["event_id"];
            setcookie("event_id", "$event_id", time() + 2 * 24 * 60 * 60);
            $isActive = $row["is_active"];
            setcookie("isActive", "$isActive", time() + 2 * 24 * 60 * 60);
            if ($eventCode == null) {
                $_SESSION['ERROR'] = "Event Code does not exist!";
                header("Refresh:0");
            } else {
                if ($isActive == true) {
                    $_SESSION['name'] = $name;
                    $_SESSION['eventCode'] = $eventCode;
                    // Saves the participant in to the participants table when they join an event successfully.
                    $sql = "INSERT INTO participants(participant_name, event_id) VALUES(".
                    "'".$name."',".
                    "'".$eventID."');";			
                    pg_query($conn, $sql);

                    header("location:./events.php");
                } else {
                    $_SESSION['ERROR'] = "Event Code has expired!";
                    header("Refresh:0");
                }
            }

        }

    } else {
        $_SESSION['ERROR'] = "Event ID Not Found!";
        header("Refresh:0");
    }
}

?>
<section class="login">
        <div class="box">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" align="center">
            <h2 class="text-center">Join an Event</h2>
            <br />
            <div class="form-group">
                <input type="name" class="form-control" placeholder="Participant Name" required="required" name="name" value="<?php if (isset($_COOKIE['NAME'])) {$name = $_COOKIE['NAME'];
    echo $name;}?>">
            </div>
            <div class="form-group">
                <input type="eventCode" class="form-control" placeholder="Event Code - XXXXXX" required="required" name="eventCode" value="" maxlength="6">
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Join Event</button>
            </div>
        </form>
        </div>
</section>

<?php
include "./footer.php";
?>
