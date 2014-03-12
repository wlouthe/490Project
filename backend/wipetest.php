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
$TESTID = $_POST['testid'];

if (!empty($TEACHID))
{
    $query = mysqli_query($con,"SELECT * FROM login WHERE id = $TEACHID;");
    $row = mysqli_fetch_array($query);
    $status = $row['status'];
  	if ($status == 1)
  	{
        mysqli_query($con,"DELETE FROM testQuestions WHERE testId = $TESTID;");
    }
	else
	{
		echo "Bad Permissions";
	}
}
else
{
	echo "Missing ID";
}

mysqli_close($con);
?>