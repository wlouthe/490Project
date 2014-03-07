<html>
<head>
<?php
require "mycurl.php";
if (isset($mycode))
{
	$expire=time()+60*60;
	$mykey=$_COOKIE["mycode"];
	$url = "http://web.njit.edu/~tjh24/codechecker.php";
	$fields = array(
		'mycode' => urlencode($_POST["mycode"])
	);
	$coderesult = curlcall($fields,$url);
	
	$doc = new DOMDocument();
	$doc->loadHTML($coderesult);
	$success = $doc->getElementsByTagName('success')->item(0);
}
/////////////////////////////////////////////////////////////////////////////
//// Run Program Start
/////////////////////////////////////////////////////////////////////////////
if(isset($_POST["Program"])&&!empty($_POST["Program"]))
{
	
	$username = "";

	$mycode = "\r\nx=add2(4,5)\r\nf = open('/afs/cad/u/l/l/ss55/public_html/490server/codebin/".$username.".txt','w')\r\nprint('hello')\r\nf.write(str(x))";

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
	$process = proc_open('python /afs/cad/u/l/l/ss55/public_html/490server/codebin/'.$username.'testProgram.py',$descriptorspec,$pipes);
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

?>
</html>
