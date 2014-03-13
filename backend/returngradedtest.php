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
$TESTID = $_POST['testid'];
$CLASSID = $_POST['classid'];

if (!empty($TESTID) && !empty($STUDENT)) {
    $query = mysqli_query($con,"SELECT DISTINCT * FROM testQuestions, question 
    WHERE testQuestions.questionId = question.questionId AND testQuestions.testId = $TESTID;");
    while ($row = mysqli_fetch_array($query)) {
        $type = $row['questionType'];
        // Multiple Choice
        $i = 0;
        if ($type == 1) {
            echo "<question>";
            echo "<id>".$row['questionId']."</id>";
            echo "<type>".$row['questionType']."</type>";
            echo "<pvalue>".$row['questionValue']."</pvalue>";
            $TOTALSCORE = $TOTALSCORE + $row['questionValue'];
            echo "<name>".$row['questionQuery']."</name>";
            $QUESTIONID = $row['questionId'];
            $answer = mysqli_query($con,"SELECT * FROM answer WHERE questionId = $QUESTIONID;");
            while ($row2 = mysqli_fetch_array($answer)) {
                echo "<ans>".$row2['answerField']."</ans>";
            }
            
            $question = mysqli_query($con,"SELECT * FROM studentTestQuestions WHERE questionId = $QUESTIONID;");
            $qrow = mysqli_fetch_array($question);
            
            echo "<studentanswer>".$qrow['answer']."</studentanswer>";
            echo "<correctanswer>".$qrow['answerCorrect']."</correctanswer>";
            echo "<ansflag>".$qrow['answerFlag']."</ansflag>";

            echo "</question>";
        }
        // True False
        if ($type == 2) {
            echo "<question>";
            echo "<id>".$row['questionId']."</id>";
            echo "<type>".$row['questionType']."</type>";
            echo "<pvalue>".$row['questionValue']."</pvalue>";
            $TOTALSCORE = $TOTALSCORE + $row['questionValue'];
            echo "<name>".$row['questionQuery']."</name>";
            $QUESTIONID = $row['questionId'];
            $answer = mysqli_query($con,"SELECT * FROM answer WHERE questionId = $QUESTIONID;");
            while ($row2 = mysqli_fetch_array($answer)) {
                if ($row2['answerField'] == "True") {
                    echo "<ans>1</ans>";
                }
                else {
                    echo "<ans>2</ans>";
                }
            }

            $question = mysqli_query($con,"SELECT * FROM studentTestQuestions WHERE questionId = $QUESTIONID;");
            $qrow = mysqli_fetch_array($question);
            
            if ($qrow['answer'] == "True") {
                echo "<studentanswer>1</studentanswer>";
            }
            else {
                echo "<studentanswer>2</studentanswer>";
            }
            
            if ($qrow['answerCorrect'] == "True") {
                echo "<correctanswer>1</correctanswer>";
            }
            else {
                echo "<correctanswer>2</correctanswer>";
            }
            echo "<ansflag>".$qrow['answerFlag']."</ansflag>";
            echo "</question>";
        }
        // Fill in the blank
        if ($type == 3) {
            echo "<question>";
            echo "<id>".$row['questionId']."</id>";
            echo "<type>".$row['questionType']."</type>";
            echo "<pvalue>".$row['questionValue']."</pvalue>";
            $TOTALSCORE = $TOTALSCORE + $row['questionValue'];
            echo "<name>".$row['questionQuery']."</name>";
            $QUESTIONID = $row['questionId'];
            
            $question = mysqli_query($con,"SELECT * FROM studentTestQuestions WHERE questionId = $QUESTIONID;");
            $qrow = mysqli_fetch_array($question);
            
            echo "<studentanswer>".$qrow['answer']."</studentanswer>";
            echo "<correctanswer>".$qrow['answerCorrect']."</correctanswer>";
            echo "<ansflag>".$qrow['answerFlag']."</ansflag>";            
            
            echo "</question>";
        }
        // Programming question
        if ($type == 4) {
            echo "<question>";
            echo "<id>".$row['questionId']."</id>";
            echo "<type>".$row['questionType']."</type>";
            echo "<pvalue>".$row['questionValue']."</pvalue>";
            $TOTALSCORE = $TOTALSCORE + $row['questionValue'];
            echo "<name>".$row['questionQuery']."</name>";
            $QUESTIONID = $row['questionId'];
            
            $question = mysqli_query($con,"SELECT * FROM studentTestQuestions WHERE questionId = $QUESTIONID;");
            $qrow = mysqli_fetch_array($question);
            echo "<ansflag>".$qrow['answerFlag']."</ansflag>";
            
            echo "</question>";
        }
    }
}
else {
    echo "Missing ID.";
}

mysqli_close($con);
?>