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

$QUESTIONID = $_POST['questionid'];

$QUESTION = mysqli_real_escape_string($con, $_POST['question']);
$QUESTIONTYPE = $_POST['type']; // 1 - multiple choice, 2 - True/False, 3 - Fill in the blank, 4 - Programming
$QUESTIONVALUE = $_POST['pvalue'];
if ($QUESTIONTYPE == 1) {
    $CHOICE = array(mysqli_real_escape_string($con, $_POST['choice1']), mysqli_real_escape_string($con, $_POST['choice2']), 
                    mysqli_real_escape_string($con, $_POST['choice3']), mysqli_real_escape_string($con, $_POST['choice4']));
}
if ($QUESTIONTYPE == 4) {
    $TESTCODE = mysqli_real_escape_string($con, $_POST['testcode']);
    $TESTCASE = array(mysqli_real_escape_string($con, $_POST['testcase1']), mysqli_real_escape_string($con, $_POST['testcase2']), 
                      mysqli_real_escape_string($con, $_POST['testcase3']), mysqli_real_escape_string($con, $_POST['testcase4']));
}
$TRUFAL = array("True", "False");
$ANSWER = mysqli_real_escape_string($con, $_POST['answer']);

if (!empty($QUESTIONID)) {
    if ($QUESTIONTYPE == 1) {
        mysqli_query($con,"UPDATE question SET questionQuery = '$QUESTION', questionValue = $QUESTIONVALUE WHERE questionId = $QUESTIONID;");
        for($i = 1, $j = 0; $i < 5; $i++, $j++) {
            mysqli_query($con,"UPDATE answer SET answerField = '$CHOICE[$j]', answerCorrect = 0 WHERE questionId = $QUESTIONID AND answerLetter = $i;");
        }
        mysqli_query($con,"UPDATE answer SET answerCorrect = 1 WHERE questionId = $QUESTIONID AND answerLetter = $ANSWER;");
    }
    elseif ($QUESTIONTYPE == 2) {
        mysqli_query($con,"UPDATE question SET questionQuery = '$QUESTION', questionValue = $QUESTIONVALUE WHERE questionId = $QUESTIONID;");
        mysqli_query($con,"UPDATE answer SET answerCorrect = 0 WHERE questionId = $QUESTIONID AND answerLetter != $ANSWER;");
        mysqli_query($con,"UPDATE answer SET answerCorrect = 1 WHERE questionId = $QUESTIONID AND answerLetter = $ANSWER;");
    }
    elseif ($QUESTIONTYPE == 3) {
        mysqli_query($con,"UPDATE question SET questionQuery = '$QUESTION', questionValue = $QUESTIONVALUE WHERE questionId = $QUESTIONID;");
        mysqli_query($con,"UPDATE answer SET answerField = '$ANSWER', answerCorrect = 1 WHERE questionId = $QUESTIONID;");
    }
    elseif ($QUESTIONTYPE == 4) {
        mysqli_query($con,"UPDATE question SET questionQuery = '$QUESTION', questionValue = $QUESTIONVALUE WHERE questionId = $QUESTIONID;");
        for($i = 1, $j = 0; $i < 5; $i++, $j++) {
            mysqli_query($con,"UPDATE answer SET answerField = '$TESTCASE[$j]' WHERE questionId = $QUESTIONID AND answerLetter = $i;");
        }
    }
    else {
        echo "<success>0</success>";
    }
}

mysqli_close($con);
?>