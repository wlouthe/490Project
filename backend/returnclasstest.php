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

$CLASSID = $_POST['classid'];

if (!empty($CLASSID)) {
    $query = mysqli_query($con,"SELECT * FROM test WHERE classId = $CLASSID;");
    while ($row = mysqli_fetch_array($query)) {
        echo "<testid>".$row['testId']."</testid>";
        echo "<testname>".$row['testName']."</testname>";
    }
}
else {
    echo "<testid>0</testid>";
    echo "<testname>0</testname>";
}

mysqli_close($con);
?>