<?php
require "mycurl.php";
$url = "http://web.njit.edu/~tjh24/editQuestion.php";

if(isset($_POST["id"]) && !empty($_POST["id"]))
{
if(isset($_POST["type"]) && !empty($_POST["type"]))
{
	
    //multiple choice
    if($_POST["type"] == 1)
    {
        $question = $_POST["question"];
        $choice1 = $_POST["answer1_"];
        $choice2 = $_POST["answer2_"];
        $choice3 = $_POST["answer3_"];
        $choice4 = $_POST["answer4_"];
        $answer = $_POST["correct"];
        $pvalue = $_POST["pvalue"];
        
        $fields = array(
            "id" => urlencode($_POST["id"]),
            "type" => urlencode($_POST["type"]),
            "question" => urlencode($question),
            "choice1" => urlencode($choice1),
            "choice2" => urlencode($choice2),
            "choice3" => urlencode($choice3),
            "choice4" => urlencode($choice4),
            "answer" => urlencode($answer),
            "pvalue" =>urlencode($pvalue),
			"teacherid" => urlencode($_POST["teacherid"]),
			"classid" => urlencode($_POST["classid"])
        );
        curlcall($fields, $url);
        
    }
    //true false
    if($_POST["type"] == 2)
    { 
        $question = $_POST["question"];
        $answer = $_POST["correct"];
        $pvalue = $_POST["pvalue"];
        
        $fields = array(
            "id" => urlencode($_POST["id"]),
            "type" => urlencode($_POST["type"]),
            "question" => urlencode($question),
            "answer" => urlencode($answer),
            "pvalue" =>urlencode($pvalue),
			"teacherid" => urlencode($_POST["teacherid"]),
			"classid" => urlencode($_POST["classid"])
        );
        curlcall($fields, $url);
        
    }
    //short answer
    if($_POST["type".$count] == 3)
    {
        $question = $_POST["question"];
        $answer = $_POST["correct"];
        $pvalue = $_POST["pvalue"];
        
        
        $fields = array(
            "id" => urlencode($_POST["id"]),
            "type" => urlencode($_POST["type"]),
            "question" => urlencode($question),
            "answer" => urlencode($answer),
            "pvalue" =>urlencode($pvalue),
			"teacherid" => urlencode($_POST["teacherid"]),
			"classid" => urlencode($_POST["classid"])
        );
        curlcall($fields, $url);
        
    }
    //program
    if($_POST["type"] == 4)
    {       
        $question = $_POST["question"];
        $testcase1 = $_POST["testcase1_"];
        $testcase2 = $_POST["testcase2_"];
        $testcase3 = $_POST["testcase3_"];
        $testcase4 = $_POST["testcase4_"];
        $pvalue = $_POST["pvalue"];
		$testcode = $_POST["testcode"];
        
        $fields = array(
            "id" => urlencode($_POST["id"]),
            "type" => urlencode($_POST["type"]),
            "question" => urlencode($question),
            "testcase1" => urlencode($testcase1),
            "testcase2" => urlencode($testcase2),
            "testcase3" => urlencode($testcase3),
            "testcase4" => urlencode($testcase4),
			"testcode" => urlencode($testcode),
            "pvalue" =>urlencode($pvalue),
			"teacherid" => urlencode($_POST["teacherid"]),
			"classid" => urlencode($_POST["classid"])
        );
        curlcall($fields, $url);
        
    }
    $tags = $_POST["tags"];
    
    if(!empty($tags) && $tags != "")
    {
        $id = $_POST["id"];
        $fields = array(
            "id" => urlencode($_POST["id"]),
        );
        curlcall($fields, "http://web.njit.edu/~tjh24/removetags.php");
        
        $mytags = explode(',',$tags);
        foreach($mytags as $tag)
        {
            $fields = array(
                "tag" => urlencode(trim($tag)),
                "questionid" =>urlencode($_POST["id"])
            );
            curlcall($fields, "http://web.njit.edu/~tjh24/addtagname.php");
        }
    }
    
}
}
?>