<?php
if(isset($_POST["txtEmail"])&&isset($_POST["txtPasswd"]))
{
    //$url = "http://web.njit.edu/~tjh24/";
   $exists=1; 
	$regex = '/^.*@.*\..*/';
	if (preg_match($regex, $_POST["txtEmail"])) 
	{
		$email = 1 ;
	} 
	else 
	{ 
		$email = 0;
	} 

if ($email)
{	
    $url = "http://web.njit.edu/~tjh24/signup.php";

	$_POST["txtPasswd"]=crypt($_POST["txtPasswd"], '$6$rounds=5000$'.$_POST["txtEmail"].$_POST["txtEmail"].'$');
	echo $_POST["txtPasswd"];
    $fields = array(
    'txtEmail' => urlencode($_POST["txtEmail"]),
    'txtPasswd' => urlencode($_POST["txtPasswd"])
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

    $doc = new DOMDocument();
    $doc->loadHTML($result);
    $exists = $doc->getElementsByTagName('exists')->item(0)->nodeValue;
}

echo "<email>".(($exists+1)%2)."</email>";
echo "<exists>".$exists."</exists>";
}
?>
