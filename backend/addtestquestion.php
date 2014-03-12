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

$TESTID = $_POST['testid'];
$TEACHID = $_POST['teachid'];
$QUESTIONID = $_POST['questionid'];

if (!empty($TESTID)) {
    // Prints all questions in specified class.
    $query = mysqli_query($con," SELECT DISTINCT questionId, questionQuery FROM question WHERE classId = $CLASSID;");
    echo "<allquestions>";
    while ($row = mysqli_fetch_array($query)) {
        echo "<id>".$row['questionId']."</id>";
        echo "<name>".$row['questionQuery']."</name>";
    }
    echo "</allquestions>";
    
    // Prints all questions already on the exam.
    $testonly = mysqli_query($con, "SELECT DISTINCT testQuestions.testQuestionId, question.questionId, question.questionQuery 
        FROM question, testQuestions WHERE testQuestions.testId = $TESTID AND testQuestions.questionId = question.questionId;");
    echo "<testquestions>";
    while ($row = mysqli_fetch_array($testonly)) {
        echo "<id>".$row['questionId']."</id>";
    }
    echo "</testquestions>";
}
else {
    echo "<testid>0</testid>";
    echo "<testname>0</testname>";
}

mysqli_close($con);
?>