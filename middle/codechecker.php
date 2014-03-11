<?php
require "mycurl.php";
if(isset($_POST["mycode"]))
{
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
        //echo "whatsup".$_POST["mycode"]."itsme";
>>>>>>> 57ca6a3b1f1c0b60ef409d77b85e452e124fe623
=======
        //echo "whatsup".$_POST["mycode"]."itsme";
>>>>>>> a91c30ab813c9bc7230fa8b15df52b5e3fa91cb9
=======
        //echo "whatsup".$_POST["mycode"]."itsme";
>>>>>>> 7e8bad24468b847f13756594bd7969b870b58dde
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
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        echo "<teacherstudent>".$teacherstudent."</teachstudent>";
<<<<<<< HEAD
<<<<<<< HEAD
		echo "<id>".$id."</id>";
=======
>>>>>>> 5b5268159a1a21b2a750d7ed7dc9e104974cd576
=======
>>>>>>> 6e23afadd043dfecde16afe7ba4db597e568e74c
=======
        echo "<teacherstudent>".$teacherstudent."</teacherstudent>";
		echo "<id>".$id."</id>";
>>>>>>> 57ca6a3b1f1c0b60ef409d77b85e452e124fe623
=======
        echo "<teacherstudent>".$teacherstudent."</teacherstudent>";
		echo "<id>".$id."</id>";
>>>>>>> a91c30ab813c9bc7230fa8b15df52b5e3fa91cb9
=======
        echo "<teacherstudent>".$teacherstudent."</teacherstudent>";
		echo "<id>".$id."</id>";
>>>>>>> 7e8bad24468b847f13756594bd7969b870b58dde
}
?>