<?php
require "mycurl.php";
$count = 0;
if(isset($_POST["teachid"]) && isset($_POST["testid"]))
{
    $success=1;
    while(isset($_POST["mycb".$count]))
    {
        if(!empty($_POST["mycb".$count]))
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
}
?>