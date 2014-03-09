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
            $id = $doc->getElementsByTagName('id')->item(0)->nodeValue;
			setcookie('mycode',$mykey,$expire,'/');
			$cookiechecker=1;
		}
		else 
		{
			echo '<meta http-equiv="refresh" content="1; url=index.php" /></head><body></body>';
		}
        if(isset($_POST["iclassname"]))
        {
            $url = "http://web.njit.edu/~ss55/490server/addclass.php";
            $fields = array(
                'id' => urlencode($id),
                'classname' => urlencode($_POST["iclassname"])
            );
            $coderesult = curlcall($fields,$url);
        }
		
	}
?>
</head>
<body>
<div class="nav-wrapper">
<?php
	if ($cookiechecker==1)
	{
		echo "Welcome ".$uname."! <a href="logout.php">Logout?</a>";
	}
?>
	</div>

<div class="main-class">
<?php
	if($cookiechecker==1)
	{
        //this should find out whether the user is a teacher or student, their ID and username, and if its a teacher
		// it should find the teachers classes, the test creation page, and the question creation page.
		// If its a student, it should find the students classes, and available tests.
		
        
		// status==2 is teacher, status==1 is student, and status==0 is unassigned.
		if($teacherstudent==1)
		{
            /*
            $url = "http://web.njit.edu/~ss55/490server/getclasses.php";
            $fields = array(
                'txtUsername' => urlencode($uname),
                'teacherstudent' =>urlencode($teacherstudent)
            );
            $myresult=curlcall($fields, $url);
            $doc = new DOMDocument();
            $doc->loadHTML($myresult);
            $status = $doc->getElementsByTagName('status')->item(0)->nodeValue;
            $classes = $doc->getElementsByTagName('classes');
            */
            
			//show classes. upon clicking classes, displays tests for grading/previously graded,
			// shows button to create test, shows button to create questions.
            /*
			echo "<table><tr><td><div class='mywindow'>";
			echo "Class:<select name='classes'>";
				echo "<option value='' selected='selected'></option>";
			foreach($classes as $class)
			{
				echo "<option value='".$class->nodeValue."'>".$class->nodeValue."</option>";
			}
			echo "</select></div></td><td></td></tr><tr><td></td><td></td></tr></table>";
            */
            echo '<table class="main-table">
<tr>
<td width=50%>
<h2 id="currentclasses">Check Classes</h2>
</td>
<td width=50%>
<h2>Add Class</h2>
<p>
    <form method ="post" action = "./home.php">
    Class Name:<input id="iclassname" name="iclassname" type="text">
    <br>
    <input type = "submit">
    <!--<div id="csubmit" class="submit">Submit</div>-->
    </form>
</p>
</td>
</tr>

<tr>
<td width=50%>
<h2>Create Test</h2>
<p>

</p>
</td>
<td  width=50%>
<h2>Create Questions</h2>
</td>
</tr>
</table>
';
            
		}
        elseif($teacherstudent == 0)
        {
            
        }
	}
?>
   
    </div>


</body>
</html>
