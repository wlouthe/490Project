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

$TEACHID = $_POST['id'];

if (!empty($TEACHID)) {
    $query = mysqli_query($con,"SELECT * FROM test WHERE creatorId = $TEACHID;");
    while ($row = mysqli_fetch_array($query)) {
        echo "<testId>".$row['testId']."</testId>";
        echo "<classId>".$row['classId']."</classId>";
        echo "<creatorId>".$row['creatorId']."</creatorId>";
        echo "<testName>".$row['testName']."</testName>";
    }
}
else {
    echo "<testId>0</testId>";
    echo "<classId>0</classId>";
    echo "<creatorId>0</creatorId>";
    echo "<testName>0</testName>";
}

mysqli_close($con);
?>