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

if (!empty($TEACHID))
{
    $query = mysqli_query($con,"SELECT * FROM login WHERE id = $TEACHID;");
    $row = mysqli_fetch_array($query);
    $status = $row['status'];
    echo "hey the next if statement is broke";
  	if ($status == 1)
  	{
        mysqli_query($con,"INSERT INTO class(creatorId, className, deleteRequest)
            VALUES ($TEACHID, '$CLASSNME', 0);");
    }
	else
	{
		echo "wrong permission";
	}
}
else
{
	echo "how did this happen";
}

mysqli_close($con);
?>