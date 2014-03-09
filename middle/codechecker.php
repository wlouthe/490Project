<?php
require "mycurl.php";
if(isset($_POST["mycode"]))
{
        //echo "whatsup".$_POST["mycode"]."itsme";
		$url = "http://web.njit.edu/~tjh24/codechecker.php";
		$fields = array(
		'mycode' => urlencode($_POST["mycode"])
		);
		$result = curlcall($fields,$url);

		$doc = new DOMDocument();
		$doc->loadHTML($result);
		
		$success = $doc->getElementsByTagName('success')->item(0)->nodeValue;
		$username = $doc->getElementsByTagName('username')->item(0)->nodeValue;
        $teacherstudent = $doc->getElementsByTagName('teacherstudent')->item(0)->nodeValue;
		$id = $doc->getElementsByTagName('id')->item(0)->nodeValue;
		
		echo "<success>".$success."</success>";
        echo "<username>".$username."</username>";
        echo "<teacherstudent>".$teacherstudent."</teacherstudent>";
		echo "<id>".$id."</id>";
}
?>