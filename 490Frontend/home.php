<html>
<head>
<link rel="stylesheet" href="mycss.css" type="text/css" media="screen">
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
            $teacherstudent = $doc->getElementsByTagName('teacherstudent')->item(0)->nodeValue;
			setcookie('mycode',$mykey,$expire,'/');
			$cookiechecker=1;
		}
		else 
		{
			echo '<meta http-equiv="refresh" content="1; url=index.php" /></head><body></body>';
		}
		
	}
?>
</head>
<body>
<div class="mywindow">
<?php
	if ($cookiechecker==1)
	{
		//this should find out whether the user is a teacher or student, their ID and username, and if its a teacher
		// it should find the teachers classes, the test creation page, and the question creation page.
		// If its a student, it should find the students classes, and available tests.
		$url = "http://web.njit.edu/~ss55/490server/gethome.php";
		$fields = array(
			'mycode' => urlencode($mykey)
		);
		$myresult=curlcall($fields, $url);
		$doc = new DOMDocument();
		$doc->loadHTML($myresult);
		$status = $doc->getElementsByTagName('status')->item(0)->nodeValue;
		$classes = $doc->getElementsByTagName('classes');
		echo 
		"<h3>Welcome ".$uname."!</h3>";
	}
?>
	</div>
<?php
	if($cookiechecker==1)
	{
		// status==2 is teacher, status==1 is student, and status==0 is unassigned.
		//if(isset($status) && $status==2)
		{
			//show classes. upon clicking classes, displays tests for grading/previously graded,
			// shows button to create test, shows button to create questions.
			echo "<table><tr><td><div class='mywindow'>";
			echo "Class:<select name='classes'>";
				echo "<option value='' selected='selected'></option>";
			foreach($classes as $class)
			{
				echo "<option value='".$class->nodeValue."'>".$class->nodeValue."</option>";
			}
			echo "</select></div></td><td></td></tr><tr><td></td><td></td></tr></table>";
		}
	}
?>
</body>
</html>
