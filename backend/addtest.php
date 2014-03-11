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
$TESTNME = $_POST['testname'];

if (!empty($TEACHID) && !empty($CLASSID)) {
    $query = mysqli_query($con,"SELECT * FROM login WHERE id = $TEACHID;");
    $row = mysqli_fetch_array($query);
    $status = $row['status'];
  	if ($status == 1) {
        mysqli_query($con,"INSERT INTO test(classId, creatorId, testName, deleteRequest)
            VALUES ($CLASSID, $TEACHID, '$TESTNME', 0);");

        $getid = mysqli_query($con,"SELECT MAX(testId) AS max FROM test WHERE classId = $CLASSID AND creatorId = $TEACHID;");
        $maxid = mysqli_fetch_array($getid);
        $TESTID = $maxid['max'];
        echo "<testid>".$TESTID."</testid>";
    }
	else {
		echo "Not a teacher.";
	}
}
else {
	echo "Missing ID or Class ID.";
}

mysqli_close($con);
?>