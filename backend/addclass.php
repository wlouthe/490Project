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

$USERNAME = $_POST['username'];         // Username value
$CLASSNME = $_POST['classname'];        // Class name
// $TEACHSTU = $_POST['teacherstudent'];   // Status value (1 = teacher, 0 = student)

// echo $EMAILSET;
// echo $PASSWORD;

$query = mysqli_query($con,"SELECT * FROM login WHERE user = '$USERNAME';");
if ($query)
{
	$row = mysqli_fetch_array($query);
  	if ($row['user'] == $USERNAME && $row['status'] == 1)
  	{
        $teachId = $row['id'];
        mysqli_query($con,"INSERT INTO class(creatorId, className, deleteRequest)
            VALUES ('$teachId', '$CLASSNME', '0')";
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