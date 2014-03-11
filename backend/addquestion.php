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
$TEACHID = $_POST['id'];
$CLASSID = $_POST['classid'];

$QUESTION = $_POST['question'];
$QUESTIONTYPE = $_POST['type']; // 1 - multiple choice, 2 - True/False, 3 - Fill in the blank, 4 - Programming
$QUESTIONVALUE = $_POST['pvalue'];
$CHOICE = array($_POST['choice1'], $_POST['choice2'], $_POST['choice3'], $_POST['choice4']);
$TRUFAL = array("False", "True");
$ANSWER = $_POST['answer'];

/*
$TESTID = 1;
$TEACHID = 73;
$CLASSID = 14;

$QUESTION = "programming assignment";
$QUESTIONTYPE = 4; // 1 - multiple choice, 2 - True/False, 3 - Fill in the blank, 4 - Programming
$QUESTIONVALUE = 50;
$CHOICE = array("case1", "case2", "case3", "case4");
$TRUFAL = array("True", "False");
$ANSWER = NULL;
*/

$STOREDCLASS = 0;
$QUESTIONID = 0;

if (!empty($TESTID) && !empty($TEACHID) && !empty($CLASSID)) {
    mysqli_query($con,"INSERT INTO question(classId, creatorId, questionType, questionQuery, questionValue, deleteRequest)
        VALUES($CLASSID, $TEACHID, $QUESTIONTYPE, '$QUESTION', $QUESTIONVALUE, 0);");
    
    $query = mysqli_query($con,"SELECT * FROM question WHERE questionQuery = '$QUESTION' AND creatorId = $TEACHID;");
    $row = mysqli_fetch_array($query);
    $QUESTIONID = $row['questionId'];
    
    mysqli_query($con,"INSERT INTO testQuestions(testId, creatorId, questionId)
        VALUES($TESTID, $TEACHID, $QUESTIONID);");
    if ($QUESTIONTYPE == 1) {
        for($i = 1, $j = 0; $i < 5; $i++, $j++) {
            mysqli_query($con,"INSERT INTO answer(questionId, answerLetter, answerField, answerCorrect)
                VALUES($QUESTIONID, $i, '$CHOICE[$j]', 0);");
            if ($ANSWER == $j) {
                mysqli_query($con,"UPDATE answer SET answerCorrect = 1 WHERE answerLetter = $i AND questionId = $QUESTIONID;");
            }
        }
    }
    if ($QUESTIONTYPE == 2) {
        for ($i = 1, $j = 0; $i < 3; $i++, $j++) {
            mysqli_query($con,"INSERT INTO answer(questionId, answerLetter, answerField, answerCorrect)
                VALUES($QUESTIONID, $i, '$TRUFAL[$j]', 0);");
            if ($ANSWER == $i) {
                mysqli_query($con,"UPDATE answer SET answerCorrect = 1 WHERE answerLetter = $i AND questionId = $QUESTIONID;");
            }
        }
    }
    if ($QUESTIONTYPE == 3 ) {
        mysqli_query($con,"INSERT INTO answer(questionId, answerField, answerCorrect)
            VALUES($QUESTIONID, '$ANSWER', 1);");
    }
    if ($QUESTIONTYPE == 4) {
        for($i = 0, $j = 1; $i < 4; $i++, $j++) {
            mysqli_query($con,"INSERT INTO answer(questionId, answerLetter, answerField, answerCorrect)
                VALUES($QUESTIONID, '$j', '$CHOICE[$i]', 1);");
        }
    }
}
else {
    echo "Something broke";
}

mysqli_close($con);
?>