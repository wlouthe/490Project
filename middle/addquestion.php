<?php
require "mycurl.php";
$url = "http://web.njit.edu/~tjh24/addquestion.php";
$count=0;
while(isset($_POST["type".$count]) && !empty($_POST["type".$count]))
{
	
    //multiple choice
    if($_POST["type".$count] == 1)
    {
        $question = $_POST["question".$count];
        $choice1 = $_POST["answer1_".$count];
        $choice2 = $_POST["answer2_".$count];
        $choice3 = $_POST["answer3_".$count];
        $choice4 = $_POST["answer4_".$count];
        $answer = $_POST["correct".$count];
        $pvalue = $_POST["pvalue".$count];
        
        $fields = array(
            "type" => urlencode($_POST["type".$count]),
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
        $qid = curlcall($fields, $url);
        
    }
    //true false
    if($_POST["type".$count] == 2)
    { 
        $question = $_POST["question".$count];
        $answer = $_POST["correct".$count];
        $pvalue = $_POST["pvalue".$count];
        
        $fields = array(
            "type" => urlencode($_POST["type".$count]),
            "question" => urlencode($question),
            "answer" => urlencode($answer),
            "pvalue" =>urlencode($pvalue),
			"teacherid" => urlencode($_POST["teacherid"]),
			"classid" => urlencode($_POST["classid"])
        );
        $qid = curlcall($fields, $url);
        
    }
    //short answer
    if($_POST["type".$count] == 3)
    {
        $question = $_POST["question".$count];
        $answer = $_POST["correct".$count];
        $pvalue = $_POST["pvalue".$count];
        
        
        $fields = array(
            "type" => urlencode($_POST["type".$count]),
            "question" => urlencode($question),
            "answer" => urlencode($answer),
            "pvalue" =>urlencode($pvalue),
			"teacherid" => urlencode($_POST["teacherid"]),
			"classid" => urlencode($_POST["classid"])
        );
        $qid = curlcall($fields, $url);
        
    }
    //program
    if($_POST["type".$count] == 4)
    {       
        $question = $_POST["question".$count];
        $testcase1 = $_POST["testcase1_".$count];
        $testcase2 = $_POST["testcase2_".$count];
        $testcase3 = $_POST["testcase3_".$count];
        $testcase4 = $_POST["testcase4_".$count];
        $pvalue = $_POST["pvalue".$count];
		$testcode = $_POST["testcode".$count];
        
        $fields = array(
            "type" => urlencode($_POST["type".$count]),
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
        $qid = curlcall($fields, $url);
        
    }
    $tags = $_POST["tags".$count];
    $doc = new DOMDocument();
    $doc->loadHTML($qid);
    $qid = $doc->getElementsByTagName('qid')->item(0)->nodeValue;
    if(!empty($tags) && $tags != "")
    {
        $mytags = explode(',',$tags);
        foreach($mytags as $tag)
        {
            $fields = array(
                "tag" => urlencode(trim($tag)),
                "questionid" => urlencode($qid)
            );
            curlcall($fields, "http://web.njit.edu/~tjh24/addtagname.php");
        }
    }
    $count++;
}

?>