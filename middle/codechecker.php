<?php
if(isset($_POST["mycode"]))
{
        echo "whatsup".$_POST["mycode"]."itsme";
		$url = "http://web.njit.edu/~tjh24/codechecker.php";
		$fields = array(
		'mycode' => urlencode($_POST["mycode"])
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
		
		$success = $doc->getElementsByTagName('success')->item(0)->nodeValue;
		$username = $doc->getElementsByTagName('username')->item(0)->nodeValue;
        $teacherstudent = $doc->getElementsByTagName('teacherstudent')->item(0)->nodeValue;
		
		echo "<success>".$success."</success>";
        echo "<username>".$username."</username>";
        echo "<teacherstudent".$teacherstudent."</teachstudent>";
}
?>