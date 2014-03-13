<?php
require "mycurl.php";
if(isset($_POST["studentid"]))
{
	$url = "http://web.njit.edu/~tjh24/returngradedtestlist.php";
    $fields = array(
        "studentid"=> urlencode($_POST["studentid"])
        );
    
    
	$result = curlcall($fields,$url);
	
	echo $result;
}
?>