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

/*
$TESTID = $_POST['testid'];
$TEACHID = $_POST['id'];
$CLASSID = $_POST['classid'];

$QUESTION = $_POST['question'];
$QUESTIONTYPE = $_POST['questiontype']; // 1 - multiple choice, 2 - True/False, 3 - Fill in the blank, 4 - Programming
$QUESTIONVALUE = $_POST['questionvalue'];
$CHOICEA = $_POST['choicea'];
$CHOICEB = $_POST['choiceb'];
$CHOICEC = $_POST['choicec'];
$CHOICED = $_POST['choiced'];
$ANSWER = $_POST['answer'];
*/

$TESTID = 1;
$TEACHID = 73;
$CLASSID = 14;

$QUESTION = "How gay is sid?";
$QUESTIONTYPE = 1; // 1 - multiple choice, 2 - True/False, 3 - Fill in the blank, 4 - Programming
$QUESTIONVALUE = 0;
$CHOICEA = "Very.";
$CHOICEB = "Extremely.";
$CHOICEC = "Super.";
$CHOICED = "Fabulously.";
$ANSWER = 'B';

$STOREDCLASS = 0;
$QUESTIONID = 0;

if (!empty($TESTID) && !empty($TEACHID) && !empty($CLASSID)) {
    mysqli_query($con,"INSERT INTO question(classId, creatorId, questionType, questionQuery, deleteRequest)
        VALUES($CLASSID, $TEACHID, $QUESTIONTYPE, '$QUESTION', 0);");
    
    $query = mysqli_query($con,"SELECT * FROM question WHERE questionQuery = '$QUESTION' AND creatorId = $TEACHID;");
    $row = mysqli_fetch_array($query);
    $QUESTIONID = $row['questionId'];
    if ($QUESTIONTYPE == 1) {
        $LETTER = 'A';
        for($i = 0; $i < 4; $i++) {
            mysqli_query($con,"INSERT INTO answer(questionId, answerLetter, answerField, answerCorrect)
                VALUES($QUESTIONID, '$LETTER', '$CHOICE".$LETTER."', 0);");
            if ($ANSWER == $LETTER) {
                mysqli_query($con,"UPDATE answer SET answerCorrect = 1 WHERE answerLetter = '$LETTER';");
            }
            $LETTER++;
        }
    }
}
else {
    echo "Something broke";
}

mysqli_close($con);
?>