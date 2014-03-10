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
    $query = mysqli_query($con,"SELECT * FROM class WHERE creatorId = $TEACHID;");
    while ($row = mysqli_fetch_array($query)) {
        echo "<classId>".$row['classId']."</classId>";
        echo "<creatorId>".$row['creatorId']."</creatorId>";
        echo "<className>".$row['className']."</className>";
    }
}
else {
    echo "<classId>0</classId>";
    echo "<creatorId>0</creatorId>";
    echo "<className>0</className>";
}

mysqli_close($con);
?>