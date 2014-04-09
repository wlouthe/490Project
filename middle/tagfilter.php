<?php
require "mycurl.php";
if (isset($_POST["teachid"]))
{
	$tags = explode("_-_",$_POST["tagnames"]);
	
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
			
			$doc = new DOMDocument();
			$doc->loadHTML($result);
			$qids = $doc->getElementByTagName("questionId");
			foreach($qids as $qid)
			{
				$count=0;
				foreach($tagids as $tagid)
				{
					if($tagid == $qid->nodeValue)
					{
						$count++;
					}
				}
				if($count == 0)
				{
					$tagids.push($qid->nodeValue);
				}
			}
		}
	}
	foreach($tagids as $tagid)
	{
		echo "<qid>".$tagid."</qid>";
	}
}
?>