<?php
require "mycurl.php";
if(isset($_POST["studentid"]) && isset($_POST["classid"]))
{
	$url = "http://web.njit.edu/~tjh24/returngradedtestlist.php";
    $fields = array(
        "testid"=> urlencode($_POST["testid"]),
        "studentid"=> urlencode($_POST["studentid"])
        );
    
    
	$result = curlcall($fields,$url);
	
	echo $result;
}
?>