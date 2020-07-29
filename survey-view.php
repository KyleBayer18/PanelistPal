<?php
include "./header.php";

$sID = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $_SESSION["ERROR"] = "";
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
        $sID = $_GET["id"];
        $_SESSION["SURVEY_ID"] = $id;
    }

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //GET ALL FORM DATA
    $_SESSION["ERROR"] = "";
    $surveyQuestion = trim($_POST["surveyQuestion"]);
    $surveyAnswer = trim($_POST["surveyAnswer"]) ?? "";
    $maxCharacters = trim($_POST["maxCharacters"]) ?? 250;
    
    $id = $_SESSION["SURVEY_ID"];


    $conn = db_connect();
    $sql = "SELECT * FROM surveys WHERE survey_id = $id";
    $results = pg_query($conn, $sql);
    $rows = pg_num_rows($results);

    if ($rows == 0) {
        $_SESSION["ERROR"] = "You cannot add a question to a survey that does not exist!";
    }

    if ($_SESSION["ERROR"] == "") {
        $sqlQuestion = "";
        $sqlQuestionOption = "";
        $sqlQuestionTypeTexts = "";

        $surveyAnswer == "" ? $questionType = 2 : $questionType = 1;

        $sqlQuestion = "INSERT INTO questions (prompt, is_required, question_type_id, survey_id) VALUES ('$surveyQuestion', 't', '$questionType', '$id')";
        $resultsQuestion = pg_query($conn, $sqlQuestion);

        $sqlQ = "SELECT * FROM questions ORDER BY question_id DESC LIMIT 1";
        $results_s = pg_query($conn, $sqlQ);
        $row_s = pg_fetch_assoc($results_s);
        $questionID = $row_s['question_id'];


        if ($surveyAnswer == "") {
            $sqlQuestionTypeTexts = "INSERT INTO question_type_texts(question_id, max_characters) VALUES ('$questionID', '$maxCharacters');";
            pg_query($conn, $sqlQuestionTypeTexts);
        } else {
            $choices = explode(',', $surveyAnswer);
            foreach ($choices as $choice){
                $choice = trim($choice);
                $sqlQuestionOption = "INSERT INTO question_options(option, question_id) VALUES ('$choice', '$questionID');";
                pg_query($conn, $sqlQuestionOption);
            }            
        }

        if (!$resultsQuestion) {
            $_SESSION["ERROR"] = "An error has occured while adding your question.";
            // header("refresh:0");
        } else {
            $_SESSION["ERROR"] = "Your question has been added!";
            header("location:./survey.php?survey={$id}");
        }
    }
}
?>
<section>
    <h1 align="center" style="color: var(--dark)">Add Question:</h1>
    <section class="login">
        <div class="box">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" align="center">
            <br />
            <!-- <div class="form-group">
                <input type="text" class="form-control" placeholder="Event Code" required="required" name="eventCode" minlength="6" maxlength="6" value="<?php echo $eventCode; ?>">
            </div> -->
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Question" required="required" name="surveyQuestion">
            </div>
            <label style="font-size:45%; float:left;">Seperate your answers by comma (,) if you have more than one choice. Example: (Yes, No, Never)</label>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Leave this empty if you expect a text answer." name="surveyAnswer">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Maximum character length allowed for a text answer. (Default: 250 (MAX))" name="maxCharacters" value="250">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Add Question</button>
            </div>
            <div class="form-group">
                <a href= "./survey.php?survey=<?php echo $sID; ?>" class="btn btn-success">View Survey</a>
            </div>
        </form>
        </div>
</section>

<?php
include "./footer.php";
?>