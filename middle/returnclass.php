<?php
require "mycurl.php";
if ( isset($_POST["id"]))
	{
		$url = "http://web.njit.edu/~tjh24/returnclass.php";
        $fields = array(
        'id' => urlencode($_POST["id"]));
        $result = curlcall($fields,$url);
		
        echo $result;
	}
?>