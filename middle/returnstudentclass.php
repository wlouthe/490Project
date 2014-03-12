<?php
	require "mycurl.php";
	$result = curlcall(array("studentid"=>$_POST["studentid"]), "http://web.njit.edu/~tjh24/returnstudentclass.php");
	$doc = new DOMDocument();
	$doc->loadHTML($result);
	//echo $result;
	$cids = $doc->getElementsByTagName("classid");
	$tnames = $doc->getElementsByTagName("teachername");
	$cnames = $doc->getElementsByTagName("classname");
	foreach($cids as $key=>$cid)
	{
		echo "<classid>".$cid->nodeValue."</classid><classname>".$cnames->item($key)->nodeValue." - ".$tnames->item($key)->nodeValue."</classname>";
	}
?>