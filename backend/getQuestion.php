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

// $TEACHID = $_POST['teachid'];
// $CLASSID = $_POST['classid'];
$QUESTIONID = $_POST['id'];

if (!empty($QUESTIONID)) {
    $query = mysqli_query($con,"SELECT questionType, questionQuery FROM question WHERE questionId = $QUESTIONID;");
    while ($row = mysqli_fetch_array($query)) {
        $TYPE = $row['questionType'];
        if ($TYPE == 1) {
            $getAns = mysqli_query($con,"SELECT answerLetter, answerField, answerCorrect FROM answer WHERE questionId = $QUESTIONID;");
            $getCor = mysqli_query($con,"SELECT answerLetter FROM answer WHERE questionId = $QUESTIONID AND answerCorrect = 1;");
            echo "<question>";
                echo "<type>".$TYPE."</type>";
                echo "<query>".$row['questionQuery']."</query>";
                $i = 1;
                while($ga = mysqli_fetch_array($getAns)) {
                    echo "<choice".$i.">".$ga['answerField']."</choice".$i.">";
                    $i++;
                }
                $gc = mysqli_fetch_array($getCor);
                echo "<correct>".$gc['answerLetter']."</correct>";
            echo "</question>";
        }
        elseif ($TYPE == 2) {
            $getAns = mysqli_query($con,"SELECT answerLetter, answerField, answerCorrect FROM answer WHERE questionId = $QUESTIONID;");
            $getCor = mysqli_query($con,"SELECT answerLetter FROM answer WHERE questionId = $QUESTIONID AND answerCorrect = 1;");
            echo "<question>";
                echo "<type>".$TYPE."</type>";
                echo "<query>".$row['questionQuery']."</query>";
                $gc = mysqli_fetch_array($getCor);
                echo "<correct>".$gc['answerLetter']."</correct>";
            echo "</question>";
        }
        elseif ($TYPE == 3) {
            $getAns = mysqli_query($con,"SELECT answerLetter, answerField, answerCorrect FROM answer WHERE questionId = $QUESTIONID;");
            echo "<question>";
                echo "<type>".$TYPE."</type>";
                echo "<query>".$row['questionQuery']."</query>";
                $ga = mysqli_fetch_array($getAns);
                echo "<answer>".$ga['answerField']."</answer>";
            echo "</question>";
        }
        elseif ($TYPE == 4) {
            $getAns = mysqli_query($con,"SELECT answerLetter, answerField, answerCorrect FROM answer WHERE questionId = $QUESTIONID;");
            echo "<question>";
                echo "<type>".$TYPE."</type>";
                echo "<query>".$row['questionQuery']."</query>";
                $i = 1;
                while($ga = mysqli_fetch_array($getAns)) {
                    echo "<case".$i.">".$ga['answerField']."</case".$i.">";
                    $i++;
                }
            echo "</question>";
        }
        else {
            echo "<success>0</success>";
        }
    }
}
else {
    echo "<success>0</success>";
}

/*if (!empty($TEACHID) && !empty($CLASSID)) {
    $query = mysqli_query($con,"SELECT questionId, questionType, questionQuery FROM question WHERE classId = $CLASSID AND creatorId = $TEACHID;");
    while ($row = mysqli_fetch_array($query)) {
        $TYPE = $row['questionType'];
        $QID = $row['questionId'];
        if ($TYPE == 1) {
            $getAns = mysqli_query($con,"SELECT answerLetter, answerField, answerCorrect FROM answer WHERE questionId = $QID;");
            $getCor = mysqli_query($con,"SELECT answerLetter FROM answer WHERE questionId = $QID AND answerCorrect = 1;");
            echo "<question>";
                echo "<type>".$TYPE."</type>";
                echo "<query>".$row['questionQuery']."</query>";
                $i = 1;
                while($ga = mysqli_fetch_array($getAns)) {
                    echo "<ans".$i.">".$ga['answerField']."</ans".$i.">";
                    $i++;
                }
                $gc = mysqli_fetch_array($getCor);
                echo "<correct>".$gc['answerLetter']."</correct>";
            echo "</question>";
        }
        elseif ($TYPE == 2) {
            $getAns = mysqli_query($con,"SELECT answerLetter, answerField, answerCorrect FROM answer WHERE questionId = $QID;");
            $getCor = mysqli_query($con,"SELECT answerLetter FROM answer WHERE questionId = $QID AND answerCorrect = 1;");
            echo "<question>";
                echo "<type>".$TYPE."</type>";
                echo "<query>".$row['questionQuery']."</query>";
                $gc = mysqli_fetch_array($getCor);
                echo "<correct>".$gc['answerLetter']."</correct>";
            echo "</question>";
        }
        elseif ($TYPE == 3) {
            $getAns = mysqli_query($con,"SELECT answerLetter, answerField, answerCorrect FROM answer WHERE questionId = $QID;");
            echo "<question>";
                echo "<type>".$TYPE."</type>";
                echo "<query>".$row['questionQuery']."</query>";
                $ga = mysqli_fetch_array($getAns);
                echo "<answer>".$ga['answerField']."</answer>";
            echo "</question>";
        }
        elseif ($TYPE == 4) {
            $getAns = mysqli_query($con,"SELECT answerLetter, answerField, answerCorrect FROM answer WHERE questionId = $QID;");
            echo "<question>";
                echo "<type>".$TYPE."</type>";
                echo "<query>".$row['questionQuery']."</query>";
                $i = 1;
                while($ga = mysqli_fetch_array($getAns)) {
                    echo "<case".$i.">".$ga['answerField']."</case".$i.">";
                    $i++;
                }
            echo "</question>";
        }
        else {
            echo "<success>0</success>";
        }
    }
}
else {
    echo "<success>0</success>";
}*/

mysqli_close($con);
?>