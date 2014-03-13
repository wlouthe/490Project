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
$QUESTIONTYPE = $_POST['type'];
$ANSWER = mysqli_real_escape_string($con, $_POST['answer']);
$CORRECT = $_POST['correct'];

if (!empty($QUESTIONID) && !empty($QUESTIONTYPE)) {
    $getCorrect = mysqli_query($con,"SELECT * FROM answer WHERE questionId = $QUESTIONID AND answerCorrect = 1;");
    $get = mysqli_fetch_array($getCorrect);
    $correctAnswer = $get['answerField'];
    $correctAnswerId = $get['answerId'];
    
    if ($QUESTIONTYPE == 1) {
        $query = mysqli_query($con,"SELECT answerField FROM answer WHERE answerLetter = $ANSWER AND questionId = $QUESTIONID;");
        $row = mysqli_fetch_array($query);
        $ANSWER = $row['answerField'];
        // $query = mysqli_query($con,"SELECT * FROM answer;");
        // $row = mysqli_fetch_array($query);
        // $ANSWER = $row['answerField'];
        
        mysqli_query($con,"INSERT INTO studentTestQuestions(sTestId, answerId, answer, answerCorrect, answerFlag)
        VALUES ($TESTID, $correctAnswerId, '$ANSWER', '$correctAnswer', $CORRECT);");
    }
    if ($QUESTIONTYPE == 2) {
        if ($ANSWER == 1) {
            $ANSWER = "True";
        }
        else {
            $ANSWER = "False";
        }
        mysqli_query($con,"INSERT INTO studentTestQuestions(sTestId, answerId, answer, answerCorrect, answerFlag)
        VALUES ($TESTID, $correctAnswerId, '$ANSWER', '$correctAnswer', $CORRECT);");
    }
    if ($QUESTIONTYPE == 3) {
        mysqli_query($con,"INSERT INTO studentTestQuestions(sTestId, answerId, answer, answerCorrect, answerFlag)
        VALUES ($TESTID, $correctAnswerId, '$ANSWER', '$correctAnswer', $CORRECT);");
    }
    if ($QUESTIONTYPE == 4) {
        mysqli_query($con,"INSERT INTO studentTestQuestions(sTestId, answerId, answer, answerFlag)
        VALUES ($TESTID, $correctAnswerId, '$ANSWER', $CORRECT);");
    }
}
else {
    echo "WHY GOD WHY.";
}

mysqli_close($con);
?>