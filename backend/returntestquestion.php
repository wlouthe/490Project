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
$CLASSID = $_POST['classid'];

if (!empty($TEACHID)) {
    // Prints all questions in specified class.
    $query = mysqli_query($con,"SELECT DISTINCT question.questionId, question.questionQuery FROM question, testQuestions WHERE testQuestions.testId = 1 AND question.classId = 14;");
    echo "<allquestions>";
    while ($row = mysqli_fetch_array($query)) {
        echo "<id>".$row['questionId']."</id>";
        echo "<name>".$row['questionQuery']."</name>";
    }
    echo "</allquestions>";
    
    // Prints all questions already on the exam.
    $testonly = mysqli_query($con, "SELECT DISTINCT testQuestions.testQuestionId, question.questionId, question.questionQuery 
        FROM question, testQuestions WHERE testQuestions.testId = 1 AND testQuestions.questionId = question.questionId;");
    echo "<ontest>";
    while ($row = mysqli_fetch_array($query)) {
        echo "<id>".$row['questionId']."</id>";
        echo "<name>".$row['questionQuery']."</name>";
    }
    echo "</ontest>";
}
else {
    echo "<testid>0</testid>";
    echo "<testname>0</testname>";
}

mysqli_close($con);
?>