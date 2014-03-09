<?php
require "mycurl.php";
if(isset($_POST["txtEmail"])&&isset($_POST["txtPasswd"]))
{   
    $exist=1;
	$regex = '/^.*(@njit\.edu)$/';
	if (preg_match($regex, $_POST["txtEmail"])) 
	{
		$email = 1;
	}
	else 
	{ 
		$email = 0;
	}
	
    if($_POST["teacherstudent"] == "teacher")
    {
        $teacherstudent = 1;
    }
    else $teacherstudent = 0;
if ($email && strlen($_POST['txtPasswd'])>7)
{
    $regex = "/[a-zA-Z0-9\.-]*/";
    preg_match($regex, $_POST["txtEmail"],$myans);
    $username = $myans[0];
    preg_match("/[0-9]/",$username,$tcheck);
    if(preg_match("/[0-9]/",$username))
    {
        $tcheck = 0;
    }
    else $tcheck = 1;
	
    $teacherstudent = $teacherstudent & $tcheck;
    $url = "http://web.njit.edu/~tjh24/signup.php";

	$_POST["txtPasswd"]=crypt($_POST["txtPasswd"], '$6$rounds=5000$'.$_POST["txtEmail"].$_POST["txtEmail"].'$');
    $fields = array(
    'txtEmail' => urlencode($_POST["txtEmail"]),
    'txtPasswd' => urlencode($_POST["txtPasswd"]),
    'username' => urlencode($username),
    'teacherstudent' => urlencode($teacherstudent)
    );
    
	$result = curlcall($fields,$url);
	$doc = new DOMDocument();
    $doc->loadHTML($result);
    $exists = $doc->getElementsByTagName('exists')->item(0)->nodeValue;
}

echo "<exists>".$exists."</exists>";
}
?>