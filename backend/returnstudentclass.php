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

if (!empty($STUDENT)) {
    $query = mysqli_query($con,"SELECT DISTINCT class.classId, class.className, login.user FROM studentClass, class, login 
        WHERE class.classId = studentClass.classId AND studentClass.teacherId = login.id AND studentClass.studentId = $STUDENT;");
    while ($row = mysqli_fetch_array($query)) {
        echo "<classid>".$row['classId']."</classid>";
        echo "<classname>".$row['className']."</classname>";
        echo "<teachername>".$row['user']."</teachername>";
    }
}
else {
    echo "<classid>0</classid>";
    echo "<classname>0</classname>";
    echo "<teachername>0</teachername>";
}

mysqli_close($con);
?>