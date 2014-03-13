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
$STUDENT = $_POST['studentid'];
$MAXSCORE = 0;
$CURSCORE = 0;

if (!empty($TESTID) && !empty($STUDENT)) {
    $query = mysqli_query($con,"SELECT * FROM studentTestQuestions WHERE studentId = $STUDENT AND stestId = $TESTID;");
    while ($row = mysqli_fetch_array($query)) {
        if ($row['answerFlag'] == 1) {
            $CURSCORE = $CURSCORE + $row['score'];
        }
    }
    $query = mysqli_query($con,"SELECT * FROM studentTest WHERE studentId = $STUDENT AND testId = $TESTID;");
    $row = mysqli_fetch_array($query);
    $MAXSCORE = $row['totalScore'];
    
    echo "<testid>".$row['testId']."</testid>";
    echo "<curscore>".$CURSCORE."</curscore>";
    echo "<maxscore>".$MAXSCORE."</maxscore>";
    
    mysqli_query($con,"UPDATE studentTest SET score = $CURSCORE WHERE studentId = $STUDENT AND testId = $TESTID;");
}

mysqli_close($con);
?>