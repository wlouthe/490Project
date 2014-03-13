<?php
require "mycurl.php";
if(isset($_POST["studentid"]) && isset($_POST["testid"]) )
{	$success = 1;
	$count = 0;
    while(isset($_POST["questionid".$count]))
    {
        if(isset($_POST["answer".$count]))
        {
            $url = "http://web.njit.edu/~tjh24/storestudenttest.php";
            $fields = array(
                'testid' => urlencode($_POST["testid"]),
                'studentid' => urlencode($_POST["studentid"]),
                'questionid' => urlencode($_POST["questionid".$count]),
				'answer' => urlencode($_POST["answer".$count])
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