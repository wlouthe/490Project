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

$TEACHID = $_POST['teacherid'];
$CLASSID = $_POST['classid'];

$QUESTION = $_POST['question'];
$QUESTIONTYPE = $_POST['type']; // 1 - multiple choice, 2 - True/False, 3 - Fill in the blank, 4 - Programming
$QUESTIONVALUE = $_POST['pvalue'];
if ($QUESTIONTYPE == 1) {
    $CHOICE = array($_POST['choice1'], $_POST['choice2'], $_POST['choice3'], $_POST['choice4']);
}
if ($QUESTIONTYPE == 4) {
    $TESTCODE = $_POST['testcode'];
    $TESTCASE = array($_POST['testcase1'], $_POST['testcase2'], $_POST['testcase3'], $_POST['testcase4']);
}
$TRUFAL = array("True", "False");
$ANSWER = $_POST['answer'];

/*
$TEACHID = 73;
$CLASSID = 14;

$QUESTION = "true false again";
$QUESTIONTYPE = 2; // 1 - multiple choice, 2 - True/False, 3 - Fill in the blank, 4 - Programming
$QUESTIONVALUE = 50;
$CHOICE = array("case1", "case2", "case3", "case4");
$TRUFAL = array("True", "False");
$ANSWER = 1;
*/

$QUESTIONID = 0;

if (!empty($TEACHID) && !empty($CLASSID)) {
    mysqli_query($con,"INSERT INTO question(classId, creatorId, questionType, questionQuery, questionValue, deleteRequest)
        VALUES($CLASSID, $TEACHID, $QUESTIONTYPE, '$QUESTION', $QUESTIONVALUE, 0);");
    
    $query = mysqli_query($con,"SELECT * FROM question WHERE questionQuery = '$QUESTION' AND creatorId = $TEACHID;");
    $row = mysqli_fetch_array($query);
    $QUESTIONID = $row['questionId'];
    if ($QUESTIONTYPE == 1) {
        for($i = 1, $j = 0; $i < 5; $i++, $j++) {
            mysqli_query($con,"INSERT INTO answer(questionId, answerLetter, answerField, answerCorrect)
                VALUES($QUESTIONID, $i, '$CHOICE[$j]', 0);");
            if ($ANSWER == $i) {
                mysqli_query($con,"UPDATE answer SET answerCorrect = 1 WHERE answerLetter = $i AND questionId = $QUESTIONID;");
            }
        }
    }
    else {
        echo "type 1 broke";
    }
    if ($QUESTIONTYPE == 2) {
        for ($i = 1, $j = 0; $i < 3; $i++, $j++) {
            mysqli_query($con,"INSERT INTO answer(questionId, answerLetter, answerField, answerCorrect)
                VALUES($QUESTIONID, $i, '$TRUFAL[$j]', 0);");
            if ($ANSWER == ($j+1)) {
                mysqli_query($con,"UPDATE answer SET answerCorrect = 1 WHERE answerLetter = $i AND questionId = $QUESTIONID;");
            }
            echo "if end";
        }
    }
    else {
        echo "type 2 broke";
    }
    if ($QUESTIONTYPE == 3 ) {
        mysqli_query($con,"INSERT INTO answer(questionId, answerField, answerCorrect)
            VALUES($QUESTIONID, '$ANSWER', 1);");
    }
    else {
        echo "type 3 broke";
    }
    if ($QUESTIONTYPE == 4) {
        for($i = 1, $j = 0; $i < 5; $i++, $j++) {
            mysqli_query($con,"INSERT INTO answer(questionId, answerLetter, answerField, answerCorrect)
                VALUES($QUESTIONID, '$i', '$TESTCASE[$j]', 1);");
        }
        mysqli_query($con,"UPDATE question SET questionTestCode = '$TESTCODE' WHERE questionId = $QUESTIONID;");
    }
    else {
        echo "type 4 broke";
    }
}
else {
    echo "Something broke";
}

mysqli_close($con);
?>