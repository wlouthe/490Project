<?php
require "mycurl.php";
//echo "<hello>123</hello>";
if (isset($_POST["teachid"]))
{
	$tags = explode(",",$_POST["tagnames"]);
	//print_r($tags);
	$tagids = array();
	
	foreach($tags as $tag)
	{
		if(!empty($tag) && $tag!='')
		{
			$url = "http://web.njit.edu/~tjh24/returntag.php";
			$fields = array(
				'teachid' => urlencode($_POST["teachid"]),
				'classid' => urlencode($_POST["classid"]),
				'tagname' => urlencode($tag)
			);
			$result = curlcall($fields,$url);
			//echo $result;
			$doc = new DOMDocument();
			$doc->loadHTML($result);
			$qids = $doc->getElementsByTagName("questionid");
			foreach($qids as $qid)
			{
				//echo $qid->nodeValue;
				$count=0;
				foreach($tagids as $tagid)
				{
					//echo $tagid;
					if($tagid == $qid->nodeValue)
					{
						$count++;
					}
				}
				if($count == 0)
				{
					array_push($tagids,$qid->nodeValue);
				}
				//print_r($tagids);
			}
		}
	}
	echo '<?xml version="1.0" encoding="UTF-8"?><myids>';
	foreach($tagids as $tagid)
	{
		echo "<qid>".$tagid."</qid>";
	}
	echo "</myids>";
}
?>