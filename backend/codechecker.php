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

if (isset($CODE) && !empty($CODE))
{
    echo $CODE;
    $query = mysqli_query($con,"SELECT * FROM login WHERE code = '$CODE';");
	$row = mysqli_fetch_array($query);
	if ($row['code'] == $CODE)
	{
        $username = $row['user'];
        $userId = $row['id'];
        $status = $row['status'];
		echo "<success>1</success>";
        echo "<id>$userId</id>";
        echo "<username>$username</username>";
        echo "<teacherstudent>$status</teacherstudent>";
	}
	else
	{
        echo "<id>0</id>";
		echo "<success>0</success>";
        echo "<username>0</username>";
        echo "<teacherstudent>0</teacherstudent>";
	}
}
else
{
    echo "<id>0</id>";
    echo "<success>0</success>";
    echo "<username>0</username>";
    echo "<teacherstudent>0</teacherstudent>";
}

mysqli_close($con);
?>