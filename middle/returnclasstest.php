<?php
require "mycurl.php";
if (isset($_POST["classid"]))
	{
		$url = "http://web.njit.edu/~tjh24/returnstudenttest.php";
        $fields = array(
		'studentid' => urlencode($_POST["studentid"]),
		'classid' => urlencode($_POST["classid"])
		);
        $result = curlcall($fields,$url);
    	 //echo "hello:".$result.":hello";
        $doc = new DOMDocument();
        $doc->loadHTML($result);
        $testids = $doc->getElementsByTagName('testid');
        $testnames = $doc->getElementsByTagName('testname');
    
        foreach($testids as $key => $testid)
        {
            echo "<testid>".$testid->nodeValue."</testid><testname>".$testnames->item($key)->nodeValue."</testname>";
        }
    
	}
?>