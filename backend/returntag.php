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

$TEACHID = $_POST['teachid'];
$CLASSID = $_POST['classid'];
$TAGNAME = $_POST['tagname'];

if (!empty($TEACHID) && !empty($CLASSID) && !empty($TAGNAME)) {
    $getQID = mysqli_query($con,"SELECT * FROM question WHERE classId = $CLASSID AND creatorId = $TEACHID;");
    while ($read = mysqli_fetch_array($getQID)) {
        $QID = $read['questionId'];
        $query = mysqli_query($con,"SELECT * FROM tags WHERE questionId = $QID AND tagName = '$TAGNAME';");
        while ($row = mysqli_fetch_array($query)) {
            echo "<questionid>".$row['questionId']."</questionid>";
        }
    }
}
elseif (!empty($TEACHID) && !empty($CLASSID)) {
    $query = mysqli_query($con,"SELECT DISTINCT tagName FROM tags, question 
        WHERE classId = $CLASSID AND creatorId = $TEACHID AND question.questionId = tags.questionId");
    while ($row = mysqli_fetch_array($query)) {
        echo "<tag>".$row['tagName']."</tag>";
    }
}
else {
    echo "Something is broken :(";
}

mysqli_close($con);
?>