<?php
	require "mycurl.php";
	curlcall(array("studentid"=>urlencode($_POST["studentid"]),"classid"=>urlencode($_POST["classid"])), "http://web.njit.edu/~tjh24/addstudentclass.php");
?>