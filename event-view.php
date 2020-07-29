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
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $_SESSION["EVENT_ID"] = $id;
        $conn = db_connect();

        $sql = "SELECT * FROM events WHERE event_id = '$id'";

        $results = pg_query($conn, $sql);

        while ($row = pg_fetch_assoc($results)) {
            $eventCode = $row["event_code"];
            $eventTitle = $row["title"];
            $eventDescription = $row["description"];
            $eventImgUrl = $row["image_url"];
            $max = $row["max_participants"];
            $isActive = $row["is_active"];
            $managerID = $row["event_manager_id"];
            $_SESSION["ACTIVE"] = $isActive;

        }
    }

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //GET ALL FORM DATA
    $_SESSION["ERROR"] = "";
    // $eventCode = trim($_POST["eventCode"]);
    $eventTitle = trim($_POST["eventTitle"]);
    $eventDescription = trim($_POST["eventDescription"]);
    $eventImgUrl = $_POST["eventImgUrl"];
    $eventMax = $_POST["eventMaxParticipants"];
    $managerID = $_SESSION["MANAGER_ID"];

    //CHECK IF EVENT IS UNIQUE
    $conn = db_connect();

    // $sql = "SELECT * FROM events WHERE event_code = '$eventCode'";

    // $results = pg_query($conn, $sql);

    // $rows = pg_num_rows($results);

    // if($rows > 0){
    //     $_SESSION["ERROR"] = "Please select a different event code, " + $eventCode + " is already in use.";
    // }

    if ($_SESSION["ERROR"] == "") {
        $id = $_SESSION["EVENT_ID"];
        $sql = "UPDATE events SET title = '$eventTitle', description = '$eventDescription', image_url = '$eventImgUrl', max_participants = '$eventMax', is_active = 'TRUE' WHERE event_id = '$id'";
        $results = pg_query($conn, $sql);

        if (!$results) {
            $_SESSION["ERROR"] = "An error has occured while updating your event.";
        } else {
            $_SESSION["ERROR"] = "Your event has been UPDATED!";
            header("location:./manager-panel.php");
        }
    }
}
?>
<section>
    <h1 align="center" style="color: var(--dark)">Edit Event:</h1>
    <section class="login">
        <div class="box">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" align="center">
            <br />
            <!-- <div class="form-group">
                <input type="text" class="form-control" placeholder="Event Code" required="required" name="eventCode" minlength="6" maxlength="6" value="<?php echo $eventCode; ?>">
            </div> -->
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Event Title" required="required" name="eventTitle" value="<?php echo $eventTitle; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Event Description" required="required" name="eventDescription" value="<?php echo $eventDescription; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Image URL" required="required" name="eventImgUrl" value="<?php echo $eventImgUrl; ?>">
            </div>
            <div class="form-group">
                <input type="number" class="form-control" placeholder="Max Participants" required="required" name="eventMaxParticipants" min="1" max="200" value="<?php echo $max; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="isActive" disabled="true" required="required" name="isActive" value="Event Status: <?php $isActive == 't' ? print "Active" : print "Inactive";?>">
            </div>
            <?php
$isActive = $_SESSION["ACTIVE"];
if ($isActive == "t") {
    echo " <div class='form-group'>
                    <a href='event-actions.php?disable=$id' class='btn btn-danger'>Disable</a>
                </div>";
} else {
    echo " <div class='form-group'>
                    <a href='event-actions.php?enable=$id' class='btn btn-success'>Enable</a>
                </div>";
}
?>
            <div class="form-group">
                <a href="event-actions.php?delete=<?php echo $id; ?>" class="btn btn-danger">Delete</a>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
        </div>
</section>
</br>
<section class="boxes">
<?php
$id = $_SESSION["EVENT_ID"];
$conn = db_connect();
$sql = "SELECT * FROM surveys WHERE event_id = '$id'";
$results = pg_query($conn, $sql);

if (!$results) {
    $_SESION["ERROR"] = "An error has occured while getting your events.";
}
while ($row = pg_fetch_assoc($results)) {
    $surveyID = $row["survey_id"];
    $surveyTitle = $row["title"];
    $surveyImageURL = $row["image_url"];
    echo "<div class=\"box one\">";
    echo "<a href='./survey-view.php?id=$surveyID'><img src='$surveyImageURL' alt='$surveyTitle' style='width:100px; height:100px;'></a>";
    echo "<hr />";
    echo "<a href='./export-survey.php?id=$surveyID' class='btn btn-success'>Export Results</a>";
    echo "</div>";
}
echo "<div class=\"box one\">";
echo "<a title='Add a new survey to this event!' href='./survey-create.php?event={$id}'><img src='http://pluspng.com/img-png/free-png-plus-sign-plus-icon-512.png' alt='Create new Survey' style='width:100px; height:100px;'></a>";?>
    </div>
</section>
<?php
include "./footer.php";
?>