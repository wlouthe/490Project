<?php
require "mycurl.php";
if ( isset($_POST["teachid"]) && isset($_POST["classid"]) && isset($_POST["testname"]))
	{
		$url = "http://web.njit.edu/~tjh24/addtest.php";
        $fields = array(
        'teachid' => urlencode($_POST["teachid"]),
		'classid' => urlencode($_POST["classid"]),
		'testname' => urlencode($_POST["testname"]));
        $result = curlcall($fields,$url);
		
		$doc = new DOMDocument();
		$doc->loadHTML($coderesult);
		$testid = $doc->getElementsByTagName('testid')->item(0)->nodeValue;
		echo "<testid>".$testid."</testid>";
		
	}
?>