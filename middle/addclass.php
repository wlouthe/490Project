<?php
require "mycurl.php";
echo "hello its me shady";
if (isset($_POST["id"]) && isset($_POST["classname"]))
	{
		$url = "http://web.njit.edu/~tjh24/addclass.php";
        $fields = array(
        'id' => urlencode($_POST["id"]),
        'classname' =>urlencode($_POST["classname"])
        );
        $result = curlcall($fields,$url);
        echo $result;
	}
	
?>