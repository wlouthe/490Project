<?php
require "mycurl.php";
if(isset($_POST["teachid"]) && isset($_POST["testid"]))
{
    $count = 0;
    $fields = array(
        "testid"=> urlencode($_POST["testid"]),
        "teachid"=> urlencode($_POST["teachid"])
        );
    curlcall($fields, "http://web.njit.edu/~tjh24/wipetest.php");
    $success=1;
    while(isset($_POST["checkcb".$count]))
    {
        if(isset($_POST["mycb".$count]) && !empty($_POST["mycb".$count]))
        {
            $url = "http://web.njit.edu/~tjh24/addtestquestion.php";
            $fields = array(
                'testid' => urlencode($_POST["testid"]),
                'teachid' => urlencode($_POST["teachid"]),
                'questionid'=>urlencode($_POST["mycb".$count])
            );
            $result = curlcall($fields,$url);
            
            $doc = new DOMDocument();
            $doc->loadHTML($result);
        
            $success = $doc->getElementsByTagName('success')->item(0)->nodeValue * $success;
        }
        $count++;    
    }
    echo "<success>".$success."</success>";
}
?>