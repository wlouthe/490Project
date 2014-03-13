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
$QUESTIONID = $_POST['questionid'];
$QUESTIONTYPE = $_POST['questiontype'];
$ANSWER = mysqli_real_escape_string($con, $_POST['answer']);

echo $ANSWER;

if (!empty($TESTID) && !empty($STUDENT) && !empty($QUESTIONID) && !empty($QUESTIONTYPE)) {
    $getCorrect = mysqli_query($con,"SELECT * FROM answer WHERE questionId = $QUESTIONID AND answerCorrect = 1;");
    $get = mysqli_fetch_array($getCorrect);
    $correctAnswer = $get['answerField'];
    $correctAnswerId = $get['answerId'];
    
    if ($QUESTIONTYPE == 1) {
        $query = mysqli_query($con,"SELECT answerField FROM answer WHERE answerLetter = $ANSWER AND questionId = $QUESTIONID;");
        $row = mysqli_fetch_array($query);
        $ANSWER = $row['answerField'];
        if ($ANSWER == $correctAnswer) {
            mysqli_query($con,"INSERT INTO studentTestQuestions(sTestId, answerId, answer, answerCorrect, answerFlag)
            VALUES ($TESTID, $correctAnswerId, '$ANSWER', '$correctAnswer', 1);");
        }
        else {
            mysqli_query($con,"INSERT INTO studentTestQuestions(sTestId, answerId, answer, answerCorrect, answerFlag)
            VALUES ($TESTID, $correctAnswerId, '$ANSWER', '$correctAnswer', 0);");
        }
    }
    if ($QUESTIONTYPE == 2) {
        if ($ANSWER == 1) {
            $ANSWER = "True";
        }
        else {
            $ANSWER = "False";
        }
        
        if ($ANSWER == $correctAnswer) {
            mysqli_query($con,"INSERT INTO studentTestQuestions(sTestId, answerId, answer, answerCorrect, answerFlag)
            VALUES ($TESTID, $correctAnswerId, '$ANSWER', '$correctAnswer', 1);");
        }
        else {
            mysqli_query($con,"INSERT INTO studentTestQuestions(sTestId, answerId, answer, answerCorrect, answerFlag)
            VALUES ($TESTID, $correctAnswerId, '$ANSWER', '$correctAnswer', 0);");
        }
    }
    if ($QUESTIONTYPE == 3) {
        if ($ANSWER == $correctAnswer) {
            mysqli_query($con,"INSERT INTO studentTestQuestions(sTestId, answerId, answer, answerCorrect, answerFlag)
            VALUES ($TESTID, $correctAnswerId, '$ANSWER', '$correctAnswer', 1);");
        }
        else {
            mysqli_query($con,"INSERT INTO studentTestQuestions(sTestId, answerId, answer, answerCorrect, answerFlag)
            VALUES ($TESTID, $correctAnswerId, '$ANSWER', '$correctAnswer', 0);");
        }
    }
}
else {
    echo "WHY GOD WHY.";
}

mysqli_close($con);
?>