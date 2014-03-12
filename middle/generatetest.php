<?php
require "mycurl.php";
if(isset($_POST["studentid"]) && isset($_POST["testid"]))
{
	$url = "http://web.njit.edu/~tjh24/generatetest.php"
    $fields = array(
        "testid"=> urlencode($_POST["testid"]),
        "studentid"=> urlencode($_POST["studentid"])
        );
	$result = curlcall($fields,$url);
	
	echo $result;
}
?>