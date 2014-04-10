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

$TAGNAME  = mysqli_real_escape_string($con, $_POST['tag']);
$QUESTION = $_POST['questionid'];

if (!empty($TAGNAME) && !empty($QUESTION)) {
    mysqli_query($con,"INSERT INTO tags(questionId, tagName, deleteRequest) VALUES ($QUESTION, lower('$TAGNAME'), 0);");
}
else {
	echo "<success>0</success>";
}

mysqli_close($con);
?>