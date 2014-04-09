<?php
require "mycurl.php";
if (isset($_POST["teachid"]))
{
	//print_r($tags);
	$tagids = array();
	
    $url = "http://web.njit.edu/~tjh24/returnsearch.php";
    $fields = array(
        'teachid' => urlencode($_POST["teachid"]),
        'classid' => urlencode($_POST["classid"]),
        'keyword' => urlencode($_POST["keyword"])
    );
    $result = curlcall($fields,$url);
    //echo $result;
    $doc = new DOMDocument();
    $doc->loadHTML($result);
    $qids = $doc->getElementsByTagName("questionid");
    foreach($qids as $qid)
    {
        array_push($tagids,$qid->nodeValue);
    }
	echo '<?xml version="1.0" encoding="UTF-8"?><myids>';
	foreach($tagids as $tagid)
	{
		echo "<qid>".$tagid."</qid>";
	}
	echo "</myids>";
}
?>