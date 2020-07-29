<?php
include "./header.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
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
    $email = "";
    $pass = "";
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //GET ALL FORM DATA
    $_SESSION["ERROR"] = "";
    $eventCode = trim($_POST["eventCode"]);
    $eventTitle = trim($_POST["eventTitle"]);
    $eventDescription = trim($_POST["eventDescription"]);
    $eventImgUrl = $_POST["eventImgUrl"];
    $eventMax = $_POST["eventMaxParticipants"];
    $managerID = $_SESSION["MANAGER_ID"];

    //CHECK IF EVENT IS UNIQUE
    $conn = db_connect();

    $sql = "SELECT * FROM events WHERE event_code = '$eventCode'";

    $results = pg_query($conn, $sql);

    $rows = pg_num_rows($results);

    if ($rows != 0) {
        $_SESSION["ERROR"] = "Please select a different event code, $eventCode is already in use.";
    }

    if ($_SESSION["ERROR"] == "") {
        $sql = "INSERT INTO events (event_code, title, description, image_url, max_participants, is_active, event_manager_id) VALUES ('$eventCode', '$eventTitle', '$eventDescription', '$eventImgUrl', '$eventMax', 'TRUE', '$managerID')";

        $results = pg_query($conn, $sql);

        if (!$results) {
            $_SESSION["ERROR"] = "An error has occured while creating your event.";
        } else {
            $_SESSION["ERROR"] = "Your event has been created!";
            header("refresh:0");
        }
    }
}
?>

<section>
    <h1 align="center" style="color: var(--dark)">Create event:</h1>
    <section class="login">
        <div class="box">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" align="center">
            <br />
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Event Code" required="required" name="eventCode" minlength="6" maxlength="6">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Event Title" required="required" name="eventTitle">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Event Description" required="required" name="eventDescription">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Image URL" required="required" name="eventImgUrl">
            </div>
            <div class="form-group">
                <input type="number" class="form-control" placeholder="Max Participants" required="required" name="eventMaxParticipants" min="1" max="200">
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Create Event</button>
            </div>
        </form>
        </div>
    </section>
</section>
<br />
<h1 align="center" style="color: var(--dark)">My Events:</h1>
<section class="boxes">

    <?php
    $id = $_SESSION["MANAGER_ID"];
    $conn = db_connect();
    $sql = "SELECT * FROM events WHERE event_manager_id = '$id'";
    $results = pg_query($conn, $sql);

    if (!$results) {
        $_SESION["ERROR"] = "An error has occured while getting your events.";
    }
    while ($row = pg_fetch_assoc($results)) {
        $eventID = $row["event_id"];
        $eventCode = $row["event_code"];
        $eventTitle = $row["title"];
        $description = $row["description"];
        $imgURL = $row["image_url"];
        $max = $row["max_participants"];
        $isActive = $row["is_active"];
        echo "<div class=\"box one\">";
        echo "<h4>$eventTitle</h4><a href='./event-view.php?id=$eventID'><img src='$imgURL' alt='$eventTitle' style='width:200px;'></a>";
        echo "</div>";
    }
    ?>
    
    
</section>
<?php
include "./footer.php"
?>
