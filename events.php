<?php
include "./header.php";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $name = $_SESSION['name'];
    $eventCode = $_SESSION['eventCode'];
    $output_event_info = "";
    $output_survey_info = "";

    $_SESSION["ERROR"] = "";
    $conn = db_connect();
    $sql = "SELECT event_id, event_code, title, description, image_url, max_participants, is_active, event_manager_id FROM
        events WHERE event_code = '$eventCode'";
    $results = pg_query($conn, $sql);
    if (pg_num_rows($results) != 0) { //not zero means something was found
        while ($row = pg_fetch_assoc($results)) {
            $eventCode = $row["event_code"];
            $eventID = $row["event_id"];
            $_SESSION["EVENT_ID"] = $eventID;
            $isActive = $row["is_active"];
            $description = $row["description"];
            $eventTitle = $row["title"];
            $imageURL = $row["image_url"];
            $maxParticipants = $row["max_participants"];
            $eventManagerID = $row["event_manager_id"];
        }

        // Process event info
        $output_event_info .= "<i class=\"fas fa-ban fa-4x\"></i>";
        $output_event_info .= "<h3>" . $eventTitle . "</h3>";
        $output_event_info .= "<p>" . $description . "</p>";
        // Process survey info
        $sql = "SELECT survey_id, title, image_url FROM
        surveys WHERE event_id = '$eventID'";
        $results = pg_query($conn, $sql);
        if (pg_num_rows($results) != 0) { //not zero means something was found
            while ($row = pg_fetch_assoc($results)) {
                $surveyID = $row["survey_id"];
                $_SESSION["SURVEY_ID"] = $surveyID;
                $surveyTitle = $row["title"];
                $_SESSION["SURVEY_TITLE"] = $surveyTitle;
                $surveyImageURL = $row["image_url"];
                $_SESSION["SURVEY_IMAGE_URL"] = $surveyImageURL;
                $output_survey_info .= "<div class=\"box two\">";
                $output_survey_info .= "<i class=\"fas fa-poll-h fa-4x\"></i>";
                $output_survey_info .= "<h3>" . $surveyTitle . "</h3>";
                $output_survey_info .= "<a href=\"survey.php?survey={$surveyID}\" class=\"btn\">Join Survey</a>";
                $output_survey_info .= "</div>";
            }

        }
    } else {
        $_SESSION['ERROR'] = "Something wrong happened, please report to administrator!";
        header("Refresh:0");
    }

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

}

?>
<section class="boxes">
<h6>You have joined<b> <?php echo $eventTitle; ?></b>, please pick a survey <b><?php echo $name; ?></b>.</h6>
</section>
<section class="boxes">
    <div class="box one">
        <?php echo $output_event_info; ?>
    </div>
</section>
<section class="boxes">
    <?php echo $output_survey_info; ?>
</section>

<?php
include "./footer.php";
?>
