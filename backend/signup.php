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

$PASSWORD = $_POST['txtPasswd'];  	// Encrypted Password
$EMAILSET = $_POST['txtEmail'];		// Email value that is posted

echo $EMAILSET;
echo $PASSWORD;

$query = mysqli_query($con,"SELECT * FROM login WHERE email = '$EMAILSET';");
if (!empty($PASSWORD) && !empty($EMAILSET))
{
	$row = mysqli_fetch_array($query);
  	if ($row['email'] == $EMAILSET)
  	{
		echo "<exists>1</exists>";
	}
	else
	{
		mysqli_query($con,"INSERT INTO login(user, password, email) 
			VALUES ('$EMAILSET', '$PASSWORD', '$EMAILSET');");
		echo "<exists>0</exists>";
	}
}
else
{
	echo "<exists>1</exists>";
}

mysqli_close($con);
?>