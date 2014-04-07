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
$QUESTIONTYPE = $_POST['type'];

if (!empty($QUESTIONID)) {
    if ($QUESTIONTYPE == 1 || $QUESTIONTYPE == 2) {
        $query = mysqli_query($con,"SELECT * FROM answer WHERE answerCorrect = 1 AND questionId = $QUESTIONID;");
        while ($row = mysqli_fetch_array($query)) {
            echo "<answer>".$row['answerLetter']."</answer>";
        }
    }
    if ($QUESTIONTYPE == 3) {
        $query = mysqli_query($con,"SELECT * FROM answer WHERE answerCorrect = 1 AND questionId = $QUESTIONID;");
        while ($row = mysqli_fetch_array($query)) {
            echo "<answer>".$row['answerField']."</answer>";
        }
    }
    if ($QUESTIONTYPE == 4) {
        $query = mysqli_query($con,"SELECT answerField FROM answer WHERE questionId = $QUESTIONID;");
        $getcode = mysqli_query($con,"SELECT questionTestCode FROM question WHERE questionId = $QUESTIONID;");
        $code = mysqli_fetch_array($getcode);
        echo "<teachercode>".$code['questionTestCode']."</teachercode>";
        while ($row = mysqli_fetch_array($query)) {
            $i = 1;
            echo "<testcode".$i.">".$row['answerField']."</testcode".$i.">";
        }
    }
}

mysqli_close($con);
?>