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

$STUDENT = $_POST['studentid'];
$CLASSID = $_POST['classid'];

if (!empty($STUDENT) && !empty($CLASSID)) {
    $query = mysqli_query($con,"SELECT * FROM login WHERE id = $STUDENT;");
    $row = mysqli_fetch_array($query);
    $status = $row['status'];
  	if ($status == 0)
  	{
    $getTeachId = mysqli_query($con,"SELECT * FROM class WHERE classId = $CLASSID;");
    $row = mysqli_fetch_array($getTeachId);
    $TEACHID = $row['creatorId'];

    mysqli_query($con,"INSERT INTO studentClass(studentId, classId, teacherId)
        VALUES($STUDENT, $CLASSID, $TEACHID);");
    echo "<success>1</success>";
    }
}
else {
    echo "Missing StudentID or ClassID";
    echo "<success>0</success>";
}

mysqli_close($con);
?>