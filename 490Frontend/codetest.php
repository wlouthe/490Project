<html>
<head>
<?php
	require "mycurl.php";
	$cookiechecker=0;
	if(isset($_COOKIE["mycode"]))
	{
		$expire=time()+60*60;
		$mykey=$_COOKIE["mycode"];
		$url = "http://web.njit.edu/~ss55/490server/codechecker.php";
		$fields = array(
			'mycode' => urlencode($mykey)
		);
		$coderesult = curlcall($fields,$url);
		
		$doc = new DOMDocument();
		$doc->loadHTML($coderesult);
		$success = $doc->getElementsByTagName('success')->item(0);
		if($success->nodeValue == "1")
		{
			$success = 1;
		}
		else $success = 0;
		if($success==1)
		{
			$uname = $doc->getElementsByTagName('username')->item(0);
			$uname = $uname->nodeValue;
			setcookie('mycode',$mykey,$expire,'/');
			$cookiechecker=1;
		}
		
	}

	if($cookiechecker==1)
	{
/////////////////////////////////////////////////////////////////////////////
//// Run Program Start
/////////////////////////////////////////////////////////////////////////////
	if(isset($_POST["Program"])&&!empty($_POST["Program"]))
	{
		$username = "wlouthe123";

		$mycode = "\r\nx=add2(4,5)\r\nf = open('/afs/cad/u/l/l/ll37/public_html/codebin/".$username.".txt','w')\r\nprint('hello')\r\nf.write(str(x))";

		$handle = fopen("./codebin/".$username."testProgram.py","c");
		fwrite($handle, $_POST["Program"].$mycode);
		fclose($handle);

		//$mystring = system('python /afs/cad/u/l/l/ll37/public_html/codebin/'.$username.'testProgram.py',$retval);
		$cmd = 'python ./codebin/'.$username.'testProgram.py';
		//$mystring = `$cmd`;
		
		$descriptorspec = array(
		0 => array("pipe","r"),
		1 => array("pipe","w"),
		2 => array("file", "./codebin/".$username."error.txt","a")
		);
		$cwd = "./codebin/";
		$process = proc_open('python /afs/cad/u/l/l/ll37/public_html/codebin/'.$username.'testProgram.py',$descriptorspec,$pipes);
		if(is_resource($process))
		{
			$programrunning = stream_get_contents($pipes[1]);
			fclose($pipes[1]);
			proc_close($process);
			if (!empty($programrunning))
			{
				echo $programrunning;
				$handle2 = fopen("./codebin/".$username.".txt","r");
				$mystring2 = fread($handle2,filesize("./codebin/".$username.".txt"));
				fclose($handle2);
			}
			else
			{
				$handle2 = fopen("./codebin/".$username."error.txt","r");
				$mystring3 = fread($handle2,filesize("./codebin/".$username."error.txt"));
				fclose($handle2);
				echo $mystring3;
			}
		}
		
		//echo $cmd;
		//echo $mystring;
		//echo $retval;


		system('rm ./codebin/'.$username.'testProgram.py');
		system('rm ./codebin/'.$username.'.txt');
		system('rm ./codebin/'.$username.'error.txt');
	}
///////////////////////////////////////////////////////////////////////
////// End Run Program
///////////////////////////////////////////////////////////////////////
echo
'</head>
<body>
<form method="post" action="codetest.php">
<h3>Q:</h3>Create a python function "add2" that takes 2 integers (test case 4, 5),
adds them together, and returns them.
<h2>Test your python code here:</h2><br>
<textarea style="width:1280px; height:620px;" name="Program" id="Program">';
	if($cookiechecker==1&&isset($_POST["Program"])&&!empty($_POST["Program"]))
	{
		echo htmlspecialchars($_POST["Program"],ENT_QUOTES);
	}
echo
'</textarea>
<br>
<input type="submit">
';
//*
	if($cookiechecker==1&&isset($_POST["Program"])&&!empty($_POST["Program"]))
	{
		if(!empty($mystring2))
		{
			echo "<div>Output: ".$mystring2."</div>";
			if($mystring2 == 9)
			{
				echo "The output is correct!";
			}
			else
			{
				echo "The output is incorrect, try again";
			}
		}
		if(empty($mystring2))
		{
			echo "<div style = 'background-color:silver; color:red;'>There is an a error with your code<br></div>";
		}
	}
//*/
echo '
</form>
<div>

</div>';
/*
echo
'<script type="text/javascript">
	document.getElementById("Program").onkeydown = function(e){
		if (e.keyCode == 9) {
			this.value = this.value + " Tab Pressed!"; 
			this.focus();
			return false;
		}
	}
</script>';
//*/
echo '</body>';

}
else
{
	echo '<meta http-equiv="refresh" content="1; url=index.php" /></head><body></body>';
}
?>
</html>
