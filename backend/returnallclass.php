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

$query = mysqli_query($con,"SELECT * FROM class;");
while ($row = mysqli_fetch_array($query)) {
    echo "<classid>".$row['classId']."</classid>";
    $TEACHID = $row['creatorId'];
    $getname = mysqli_query($con,"SELECT user FROM login WHERE id = $TEACHID;");
    $user = mysqli_fetch_array($getname);
    echo "<teachername>".$user['user']."</teachername>";
    echo "<classname>".$row['className']."</classname>";
}

mysqli_close($con);
?>