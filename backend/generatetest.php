<?php
$server = "sql.njit.edu";
$user = "tjh24";
$pass = "senorita3";
$db = "tjh24";

// Create connect
$con = mysqli_connect($server, $user, $pass, $db);
// Check connection
if (mysqli_connect_errno())
{
	echo "MySQL Failed: ".mysqli_connect_error();
}

$STUDENT = $_POST['studentid'];
$TESTID = $_POST['testid'];
$CLASSID = $_POST['classid'];

if (!empty($TESTID) && !empty($STUDENT)) {
    $query = mysqli_query($con,"SELECT DISTINCT * FROM testQuestions, question WHERE testQuestions.questionId = question.questionId AND testQuestions.testId = $TESTID;");
    // $answer = mysqli_query($con,"SELECT DISTINCT * FROM testQuestions, answer WHERE testQuestions.questionId = answer.questionId AND testQuestions.testId = $TESTID;");
    while ($row = mysqli_fetch_array($query)) {
        $type = $row['questionType'];
        // Multiple Choice
        $i = 0;
        if ($type == 1) {
            echo "<question>";
            echo "<id>".$row['questionId']."</id>";
            echo "<type>".$row['questionType']."</type>";
            echo "<pvalue>".$row['questionValue']."</pvalue>";
            echo "<name>".$row['questionQuery']."</name>";
            $QUESTIONID = $row['questionId'];
            $answer = mysqli_query($con,"SELECT * FROM answer WHERE questionId = $QUESTIONID;");
            while ($row2 = mysqli_fetch_array($answer)) {
                $L = array('A', 'B', 'C', 'D');
                echo "<".$L[$i].">".$row2['answerField']."</".$L[$i].">";
                $i++;
            }
            echo "</question>";
        }
        // True False
        if ($type == 2) {
            echo "<question>";
            echo "<id>".$row['questionId']."</id>";
            echo "<type>".$row['questionType']."</type>";
            echo "<pvalue>".$row['questionValue']."</pvalue>";
            echo "<name>".$row['questionQuery']."</name>";
            $QUESTIONID = $row['questionId'];
            $answer = mysqli_query($con,"SELECT * FROM answer WHERE questionId = $QUESTIONID;");
            while ($row2 = mysqli_fetch_array($answer)) {
                $TF = array('T', 'F');
                echo "<".$TF[$i].">".$row2['answerField']."</".$TF[$i].">";
                $i++;
            }
            echo "</question>";
        }
        // Fill in the blank
        if ($type == 3) {
            echo "<question>";
            echo "<id>".$row['questionId']."</id>";
            echo "<type>".$row['questionType']."</type>";
            echo "<pvalue>".$row['questionValue']."</pvalue>";
            echo "<name>".$row['questionQuery']."</name>";
            echo "</question>";
        }
        // Programming question
        if ($type == 4) {
            echo "<question>";
            echo "<id>".$row['questionId']."</id>";
            echo "<type>".$row['questionType']."</type>";
            echo "<pvalue>".$row['questionValue']."</pvalue>";
            echo "<name>".$row['questionQuery']."</name>";
            echo "</question>";
        }
    }
    date_default_timezone_set('America/New_York');
    $TIME = time();
    $TIMESTART = date("H:i:s", $TIME);
    mysqli_query($con,"INSERT INTO studentTest(studentId, studentClassId, testId, startTime) VALUES($STUDENT, $CLASSID, $TESTID, '$TIMESTART');");
    
    echo "<timestart>".$TIMESTART."</timestart>";
}
else {
    echo "Missing ID.";
}

mysqli_close($con);
?>