<?php
	function curlcall($fields, $url)
	{
		//$url = "http://web.njit.edu/~ss55/490server/login.php";
		//$fields = array(
		//	'txtUCID' => urlencode($_POST["username"]),
		//	'txtPasswd' => urlencode($_POST["password"]),
		//	'cpassword' => urlencode($_POST["cpassword"])
		//);
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
		return $result;
	}
?>
