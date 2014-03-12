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
$TEACHID = $_POST['teachid'];
$QUESTIONID = $_POST['questionid'];

if (!empty($TESTID) && !empty($QUESTIONID)) {
    $query = mysqli_query($con,"SELECT * FROM login WHERE id = $TEACHID;");
    $row = mysqli_fetch_array($query);
    $status = $row['status'];
  	if ($status == 1)
  	{
    mysqli_query($con,"INSERT INTO testQuestions(testId, creatorId, questionId)
        VALUES($TESTID, $TEACHID, $QUESTIONID);");
    echo "<success>1</success>";
    }
}
else {
    echo "Missing TestID or QuestionID";
    echo "<success>0</success>";
}

mysqli_close($con);
?>