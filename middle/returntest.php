<?php
require "mycurl.php";
if ( isset($_POST["teachid"]) && isset($_POST["classid"]))
	{
		$url = "http://web.njit.edu/~tjh24/returntest.php";
        $fields = array(
        'teachid' => urlencode($_POST["teachid"]),
		'classid' => urlencode($_POST["classid"])
		);
        $result = curlcall($fields,$url);
    
        $doc = new DOMDocument();
        $doc->loadHTML($result);
        $testids = $doc->getElementsByTagName('testid');
        $testnames = $doc->getElementsByTagName('testname');
    
        foreach($testids as $key => $testid)
        {
            echo "<findtest><testid>".$testid->nodeValue."</testid><testname>".$testnames->item($key)->nodeValue."</testname></findtest>";
        }
    
	}
?>