<?php
require "mycurl.php";
if(isset($_POST["studentid"]) && isset($_POST["testid"]) && isset($_POST["classid"]))
{
	$url = "http://web.njit.edu/~tjh24/returngradedtest.php";
    $fields = array(
        "testid"=> urlencode($_POST["testid"]),
        "studentid"=> urlencode($_POST["studentid"]),
		"classid"=> urlencode($_POST["classid"])
        );
	$result = curlcall($fields,$url);
	
	echo $result;
}
?>