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

$TEACHID = $_POST['teachid'];
$CLASSID = $_POST['classid'];
$KEYWORD = $_POST['keyword'];

if (!empty($TEACHID) && !empty($CLASSID) && !empty($KEYWORD)) {
    $getQID = mysqli_query($con,"SELECT DISTINCT question.questionId FROM question, answer WHERE classId = $CLASSID AND creatorId = $TEACHID AND question.questionId = answer.questionId AND (question.questionQuery LIKE '%".$KEYWORD."%' OR answer.answerField LIKE '%".$KEYWORD."%');");
    while ($read = mysqli_fetch_array($getQID)) {
        $QID = $read['questionId'];
        echo "<questionid>".$read['questionId']."</questionid>";
    }
}

mysqli_close($con);
?>