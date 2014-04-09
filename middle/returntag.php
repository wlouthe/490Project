<?php
require "mycurl.php";
if (isset($_POST["teachid"]))
	{
		$url = "http://web.njit.edu/~tjh24/returntag.php";
        $fields = array(
        	'teachid' => urlencode($_POST["teachid"]),
			'classid' => urlencode($_POST["classid"])
		 );
        $result = curlcall($fields,$url);
		
        echo $result;
	}
?>