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

$TESTID = $_POST['testid'];
$RELEASE = $_POST['release'];

if (!empty($RELEASE) && !empty($TESTID)) {
    if ($RELEASE == 1) {
        mysqli_query($con,"UPDATE test SET releaseTest = 1 WHERE testId = $TESTID;");
    }
    elseif ($RELEASE == 0) {
        mysqli_query($con,"UPDATE test SET releaseTest = 0 WHERE testId = $TESTID;");
    }
    else {
        echo "<success>0</success>";
    }
}
else {
    echo "<success>0</success>";
}

mysqli_close($con);
?>