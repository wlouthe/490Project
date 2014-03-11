<?php
require "mycurl.php";
if ( isset($_POST["id"] && isset($_POST[)
	{
		$url = "http://web.njit.edu/~tjh24/returnclasses.php";
        $fields = array(
        'txtUsername' => urlencode($_POST["txtUsername"]));
        $result = curlcall($fields,$url);
		$doc = new DOMDocument();
		$doc->loadHTML($result);
		$classId = $doc->getElementsByTagName('classId')->item(0)->nodeValue;
		$creatorId = $doc->getElementsByTagName('creatorId')->item(0)->nodeValue;
		$className = $doc->getElementsByTagName('className')->item(0)->nodeValue;
	}
	echo "<classId>".$classId."</classId>";
	echo "<creatorId>".$creatorId."</creatorId>";
	echo "<className>".$className."</className>";
?>