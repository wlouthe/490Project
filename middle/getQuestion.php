<?php
require "mycurl.php";
$url = "http://web.njit.edu/~tjh24/getQuestion.php";

if(isset($_POST["id"]) && !empty($_POST["id"]))
{
        $fields = array(
            "id" => urlencode($_POST["id"])
        );
        $result = curlcall($fields, $url);
    echo $result;
}
?>