<?php
require "mycurl.php";
if(isset($_POST["studentid"]) && isset($_POST["testid"]) && isset($_POST["classid"]))
{
	$url = "http://web.njit.edu/~tjh24/returngradedtest.php";
    $fields = array(
        "studentid"=> urlencode($_POST["studentid"]),
        "testid"=> urlencode($_POST["testid"]),
		"classid"=> urlencode($_POST["classid"])
        );
	$result = curlcall($fields,$url);
	
	echo $result;
}
?>