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
$CURSCORE = 0;
$MAXSCORE = 0;

if (!empty($TESTID) && !empty($STUDENT)) {
    $query = mysqli_query($con,"SELECT * FROM test WHERE testId = $TESTID;");
    $row = mysqli_fetch_array($query);
    $TESTNAME = $row['testName'];
    echo "<test>";
    echo "<testname>".$TESTNAME."</testname>";
    $query = mysqli_query($con,"SELECT * FROM studentTestQuestions WHERE studentId = $STUDENT AND sTestId = $TESTID;");
    while ($row = mysqli_fetch_array($query)) {
        $QUESTIONID = $row['questionId'];
        $question = mysqli_query($con,"SELECT * FROM question WHERE questionId = $QUESTIONID;");
        $qrow = mysqli_fetch_array($question);
        echo "<question>".$qrow['questionQuery']."</question>";
        echo "<studentanswer>".$row['answer']."</studentanswer>";
        echo "<correctanswer>".$row['answerCorrect']."</correctanswer>";
        echo "<pvalue>".$row['score']."</pvalue>";
        if ($row['answerFlag'] == 1) {
            $CURSCORE = $CURSCORE + $row['score'];
        }
    }
    $query = mysqli_query($con,"SELECT totalScore FROM studentTest WHERE studentId = $STUDENT AND testId = $TESTID;");
    $row = mysqli_fetch_array($query);
    $MAXSCORE = $row['totalScore'];
    echo "<curscore>".$CURSCORE."</curscore>";
    echo "<maxscore>".$MAXSCORE."</maxscore>";
    echo "</test>";
}
else {
    echo "MISSING STuFF";
}

mysqli_close($con);
?>