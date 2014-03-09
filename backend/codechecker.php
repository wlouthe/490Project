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

$CODE = $_POST['mycode'];	// Code

$query = mysqli_query($con,"SELECT * FROM login WHERE code = '$CODE';");
if (isset($CODE) && !empty($CODE))
{
	$row = mysqli_fetch_array($query);
	if ($row['code'] == $CODE)
	{
		echo "<success>1</success>";
		$username = $row['user'];
        echo "<username>$username</username>";
        echo "<teacherstudent>$row['status']</teacherstudent>";
	}
	else
	{
		echo "<success>0</success>";
        echo "<username>0</username>";
        echo "<teacherstudent>0</teacherstudent>";
	}
}
else
{
    echo "<success>0</success>";
    echo "<username>0</username>";
    echo "<teacherstudent>0</teacherstudent>";
}

mysqli_close($con);
?>