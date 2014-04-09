<?php
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  ///////////  Code to Authenticate with NJIT or the Database
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //*
require "mycurl.php";

error_reporting(E_ALL);

if(isset($_POST["txtUCID"])&&isset($_POST["txtPasswd"]))
{
	//preg_match checks to see if the username is an E-mail or not
	$regex = '/^.*@.*\..*/';
	if (preg_match($regex, $_POST["txtUCID"])) 
	{
		$email = 1 ;
	} 
	else 
	{ 
		$email = 0;
	} 
    $authenticated = 0;
	
	//Encrypt $_POST['txtPasswd'] and $_POST['cpassword']
    if(isset($_POST['txtPasswd']))
    {
    $_POST['txtPasswd'] = crypt($_POST['txtPasswd'],'$6$rounds=5000$'.$_POST["txtUCID"].$_POST["txtUCID"].'$');
    }
    if(isset($_POST['cpassword'])&&!empty($_POST['cpassword']))
    {
    $_POST['cpassword'] = crypt($_POST['cpassword'],'$6$rounds=5000$'.$_POST["txtUCID"].$_POST["txtUCID"].'$');
    }
 
	//POST data to back end
    $url = "http://web.njit.edu/~tjh24/login.php";
    $fields = array(
    'txtUCID' => urlencode($_POST["txtUCID"]),
    'txtPasswd' => urlencode($_POST["txtPasswd"]),
    'cpassword' => urlencode($_POST["cpassword"]),
    'auth' => urlencode($authenticated)
    );
    $result = curlcall($fields,$url);
    
	// DOM parse what the back end echoes back
    $doc = new DOMDocument();
    $doc->loadHTML($result);
    
	$success = $doc->getElementsByTagName('auth')->item(0)->nodeValue;
	$code = $doc->getElementsByTagName('code')->item(0)->nodeValue;
    
	echo "<njitauthenticated>".$authenticated."</njitauthenticated>";
    echo "<code>".$code."</code>";
    echo "<dbauthenticated>".$success."</dbauthenticated>";
}
?>
