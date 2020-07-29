<?php
    include "./header.php";

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($_GET["id"])){
            $surveyID = $_GET["id"];
            ob_end_clean();
            $conn = db_connect();  
            $sql = "SELECT title FROM surveys WHERE survey_id = '$surveyID'";
            $name = pg_query($conn, $sql);
            while($row = pg_fetch_assoc($name)){
                $title = $row["title"];
            }
            $filename = "$title.csv";
            $output = fopen($filename, "w");  
            fputcsv($output, array('SurveyID', 'Question'));
            $sql = "SELECT survey_id, prompt from questions WHERE survey_id = '$surveyID'";  
            $results = pg_query($conn, $sql);
            while($row = pg_fetch_assoc($results)){
                fputcsv($output, $row);
            }
            fputcsv($output, array('Index', 'Answers', 'Survery ID'));  
            $sql = "SELECT * from results WHERE question_id = '$surveyID'";  
            $results = pg_query($conn, $sql); 
            while($row = pg_fetch_assoc($results))  
            {  
                fputcsv($output, $row);  
            }  
            fclose($output); 
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=".$filename);
            header("Content-Type: application/csv; "); 

            readfile($filename);
            
            // deleting file
            unlink($filename);
            exit();
            // $_SESSION["ERROR"] = "Results have been exported!";
            // header("location:./manager-panel.php");
    }
}
?>

<?php
    include "./footer.php";
?>