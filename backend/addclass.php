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
$CLASSNME = $_POST['classname'];

if ($TEACHID)
{
    $query = mysqli_query($con,"SELECT * FROM login WHERE id = $TEACHID;");
    $row = mysqli_fetch_array($query);
  	if ($row['id'] == $TEACHID && $row['status'] == 1)
  	{
        mysqli_query($con,"INSERT INTO class(creatorId, className, deleteRequest)
            VALUES ('$TEACHID', '$CLASSNME', '0')";
    }
	else
	{
		echo "error";
	}
}
else
{
	echo "No such user.";
}

mysqli_close($con);
?>