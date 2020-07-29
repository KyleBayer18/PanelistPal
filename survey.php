<?php
include "./header.php";
$output = "";
// $surveyTitle = $_SESSION["SURVEY_TITLE"];
// $surveyImageURL = $_SESSION["SURVEY_IMAGE_URL"];
$sID = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $_SESSION["ERROR"] = "";

    if(isset($_GET["survey"])){

        $id = $_GET["survey"];
        $sID = $_GET["survey"];
        $_SESSION["SID"] = $sID;

        $conn = db_connect();

        $sql = "SELECT * FROM questions WHERE survey_id = '$id' ORDER BY question_id";

        $results = pg_query($conn, $sql);

        //Survey is found
        if (pg_num_rows($results) != 0) {
            while ($row = pg_fetch_assoc($results)) {
                $questionID = $row["question_id"];
                $prompt = $row["prompt"];
                $isRequired = $row["is_required"];
                $questionType = $row["question_type_id"]; // 1 = Select, 2 = Text
                // To display the survey:
                // 1. Need to identify if the question requires a select box or a short answer.
                // 2. The event manager gets to set them when creating the survey.
                // 3. Need to retrive those data before populating the survey for participant to see.
                // 4. Populate Survey form.                
                if($questionType == 1){
                    $sql = "SELECT * FROM question_options WHERE question_id = '$questionID'";
                    $results_qo = pg_query($conn, $sql);
                    if (pg_num_rows($results_qo) != 0) {                        
                        $output .= "<div class=\"form-group\">";
                        $output .= "<label for=\"question_" . $questionID ."\">$prompt</label>";
                        $output .= "</br>";
                        $output .= "<select name=\"". $questionID . "\">";
                        $output .= "<option value=\"default\" disabled=\"true\" selected=\"true\">Select an option</option> ";
                        while ($row1 = pg_fetch_assoc($results_qo)) {
                            $option = $row1["option"];
                            $optionID = $row1["question_option_id"];
                            $output .= "<option value=\"". $option . "\">" . $option . "</option>";                                                            
                        }
                        $output .= "</select>";
                        $output .= "</div>";
                    }

                }elseif($questionType == 2){
                    $sql = "SELECT * FROM question_type_texts WHERE question_id = '$questionID'";
                    $results_qtt = pg_query($conn, $sql);
                    if (pg_num_rows($results_qtt) != 0) {
                        while ($row2 = pg_fetch_assoc($results_qtt)) {
                            $maxCharacters = $row2["max_characters"];                            
                            $output .= "<div class=\"form-group\">";
                            $output .= "<label for=\"question_" . $questionID . "\">$prompt</label>";
                            $output .= "<input type=\"text\" class=\"form-control\" placeholder=\"\" required=\"required\" name=\"" . $questionID . "\" value=\"\" maxlength=\"$maxCharacters\">";
                            $output .= "</div>";
                        }
                    }

                }else{
                    $_SESSION['ERROR'] = "Survey Could not be populated properly, please contact an administrator.";
                    header("location:./events.php");
                }
            }

        }
        
}

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["ERROR"] = "";
    // When user clicks submit survey, lots of shit happens here.
    // 1. Every question gets saved individually to results table.
    // 2. For each question result, we save who was the participant in the result_participants table.
    // 3. 

    // Save to results table
    
    foreach ($_POST as $key => $value) {
        $conn = db_connect();
        $sID = $_SESSION["SID"];
        $sql = "INSERT INTO results(question_id, value) VALUES(".
        "'".htmlspecialchars($sID)."',".
        "'".htmlspecialchars($value)."');";			
        pg_query($conn, $sql);
        header("location:./events.php");
    }

    // Save to result participants

}

?>



<section class="boxes">

</section>
<section class="box">
<?php 
    if($_SESSION["MANAGER_ID"] != ""){
        echo "<a title='Add another question to this survey!' style= \"float:left color:white\" href= \"./survey-view.php?id=$sID\" class=\"btn\">+</a>";
        echo "<br />";
    }
    
?>

    <form style="display: inline-block;"; action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <!-- <h2></h2> -->
            <br />            
            <?php echo $output; ?>
            <div class="form-group">
                <button type="submit" class="btn">Submit</button>
            </div>
        </form>
        
</section>



<?php
include "./footer.php";
?>
