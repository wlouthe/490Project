<?php
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  ///////////  Code to Authenticate with NJIT or the Database
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //*
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
    // If the username is not an email then it will be treated as a UCID and checked
	if (!$email)
	{
		$url="https://moodleauth00.njit.edu/cpip_serv/login.aspx?esname=moodle";
    
		$fields = array(
		'txtUCID' => urlencode($_POST["txtUCID"]),
		'txtPasswd' => urlencode($_POST["txtPasswd"]),
		'btnLogin' => urlencode("Login"),
		'__VIEWSTATE' => "/wEPDwUJNDIzOTY1MjU5ZGQ="
		);
		foreach($fields as $key=>$value)
		{
			$fields_string .= $key . '=' . $value . '&';
		}
		rtrim($fields_string, '&');
    
		$ch = curl_init();

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,false);
		curl_setopt($ch,CURLOPT_MAXREDIRS,0);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

		$result = curl_exec($ch);

		curl_close($ch);
    
    
		// begin dom parsing to check if login was successful
		$doc = new DOMDocument();
		$doc->loadHTML($result);
		$authentication = $doc->getElementsByTagName('title')->item(0);
		if($authentication->nodeValue == "Object moved")
		{
			$authenticated = 1;
		}
		else
		{
			$authenticated = 0;
		}
	}
	// If the username entered is an Email then the check with NJIT will be skipped
	// and by default the authenticated variable will be set to 0
	else
	{
		$authenticated = 0;
    }
	
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
    foreach($fields as $key=>$value)
    {
    $fields_string2 .= $key . '=' . $value . '&';
    }
    rtrim($fields_string2, '&');
    
    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string2);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,false);
    curl_setopt($ch,CURLOPT_MAXREDIRS,0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

    $result = curl_exec($ch);

    curl_close($ch);
    
	// DOM parse what the back end echoes back
    $doc = new DOMDocument();
    $doc->loadHTML($result);
    
	$success = $doc->getElementsByTagName('auth')->item(0)->nodeValue;
	$code = $doc->getElementsByTagName('code')->item(0)->nodeValue;
    
	echo "<NJITauthenticated>".$authenticated."</NJITauthenticated>";
    echo "<code>".$code."</code>";
    echo "<DBauthenticated>".$success."</DBauthenticated>";
}
?>
