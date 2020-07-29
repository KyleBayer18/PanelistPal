<?php
include "./header.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $_SESSION["ERROR"] = "";
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
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $_SESSION["EVENT_ID"] = $id;
    }

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["ERROR"] = "";
    $id = $_SESSION["EVENT_ID"];
    $surveyTitle = trim($_POST["surveyTitle"]);
    $surveryImgUrl = trim($_POST["surveyImgUrl"]);

    $conn = db_connect();
    $sql = "INSERT INTO surveys (title, image_url, event_id) VALUES ('$surveyTitle', '$surveryImgUrl', '$id')";
    $results = pg_query($conn, $sql);
    $sql = "SELECT * FROM surveys ORDER BY survey_id DESC LIMIT 1";
    $results_s = pg_query($conn, $sql);
    $row_s = pg_fetch_assoc($results_s);
    $surveyID = $row_s["survey_id"];
    $_SESSION["SURVEY_ID"] = $surveyID;

    if (!$results) {
        $_SESSION["ERROR"] = "There was an error creating your survery!";
    }

    if ($_SESSION["ERROR"] == "") {
        $_SESSION["ERROR"] = "Your survey has been created!";
        header("location:./survey-view.php?survey={$surveyID}");
    } else {
        header("refresh:0");
    }
}
?>
<section>
    <h1 align="center" style="color: var(--dark)">Create Survey:</h1>
    <section class="login">
        <div class="box">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" align="center">
            <br />
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Survey Title" required="required" name="surveyTitle">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Image URL" required="required" name="surveyImgUrl">
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Create Survey</button>
            </div>
        </form>
        </div>
</section>
<?php
include "./footer.php";
?>