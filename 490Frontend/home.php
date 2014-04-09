<html>
<head>
<link rel="stylesheet" href="mycss.css" type="text/css" media="screen">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
            //echo "success";
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
		
	}
    else
    {
        echo '<meta http-equiv="refresh" content="1; url=index.php" />';
    }
?>
</head>
<body>
<div class="nav-wrapper">
<?php
	if ($cookiechecker==1)
	{
		echo "Welcome ".$uname."! <a href='logout.php'>Logout?</a>";
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
			
			if(isset($_POST["iclassname"]))
			{
				$url = "http://web.njit.edu/~ss55/490server/addclass.php";
				$fields = array(
					'id' => urlencode($id),
					'classname' => urlencode($_POST["iclassname"])
				);
				$coderesult = curlcall($fields,$url);
			}
			$url = "http://web.njit.edu/~ss55/490server/returnclass.php";
			$fields = array(
				'id' => urlencode($id)
			);
			$coderesult = curlcall($fields,$url);
			$doc = new DOMDocument();
			$doc->loadHTML($coderesult);
			$classes = $doc->getElementsByTagName('classname');
			$classesid = $doc->getElementsByTagName('classid');
            echo '<table class="main-table">
<tr>
<td class="mytd" width=50%>
<h2 id="currentclasses">Release Grades</h2>';

echo '<form method="post" action="./home.php">';
echo "Class:<select id='releasegrades   ' name='classid'>";
echo "<option value='' selected='selected'></option>";
foreach($classes as $key => $class)
{
	echo "<option value='".$classesid->item($key)->nodeValue."'>".$class->nodeValue."</option>";
}
echo "</select>";
echo "</form>";
            
echo '</td>
<td class="mytd" width=50%>
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
<td class="mytd" width=50%>
<h2>Create Test</h2>
';

echo '<form id="testform" method="post" action="javascript: return false">';
echo "Class:<select name='classid'>";
echo "<option value='' selected='selected'></option>";
foreach($classes as $key => $class)
{
	echo "<option value='".$classesid->item($key)->nodeValue."'>".$class->nodeValue."</option>";
}
echo "</select>";
echo "<br>New Test:<input id='tname' name='tname' type='text'><br>";
echo "<input id='tbutton1' type='submit' value='Create New Test'><input id='tbutton2' type='submit' value='Edit Existing Test'>";
echo "</form>";

echo '
</td>
<td class="mytd" width=50%>
<h2>Create Questions</h2>';

echo '<form method="post" action="./createquestions.php">';
echo "Class:<select name='classid'>";
echo "<option value='' selected='selected'></option>";
foreach($classes as $key => $class)
{
	echo "<option value='".$classesid->item($key)->nodeValue."'>".$class->nodeValue."</option>";
}
echo "</select>";
echo "<input type='submit'>";

echo "</form>";

echo '</td>
</tr>
</table>
';
            
		}
        elseif($teacherstudent == 0)
        {
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////begin student part///////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			if(isset($_POST["sclassid"]))
			{
				$fields = array(
					"studentid"=>urlencode($id),
					"classid"=>urlencode($_POST["sclassid"])
				);
				curlcall($fields, "http://web.njit.edu/~ss55/490server/addstudentclass.php");
			}
			$result = curlcall(array(), "http://web.njit.edu/~ss55/490server/returnallclass.php");
			$doc = new DOMDocument();
			$doc->loadHTML($result);
			//echo $result;
			$cids = $doc->getElementsByTagName("classid");
			$cnames = $doc->getElementsByTagName("classname");
			echo '<table class="main-table">
			<tr>
			<td class="mytd" width=50%>
			<h2 id="currentclasses">Join Classes</h2>';
			echo '<form method="post" action="./home.php">';
			echo "Class:<select name='sclassid'>";
			echo "<option value='' selected='selected'></option>";
			$sselected="";
			foreach($cids as $key=>$cid)
			{
				if($classidset == $cid->nodeValue)
				{
					$sselected="selected";
				}
				echo "<option value='".$cid->nodeValue."'>".$cnames->item($key)->nodeValue."</option>";
			}
			echo "</select>";
			echo "<input name='submit' type='submit'>";
			echo "</form>";
						
			echo '</td>
			
			
			<td class="mytd" width=50%>';
			
			$result = curlcall(array("studentid"=>$id), "http://web.njit.edu/~ss55/490server/returnstudentclass.php");
			$doc = new DOMDocument();
			$doc->loadHTML($result);
			//echo $result;
			$cids = $doc->getElementsByTagName("classid");
			$cnames = $doc->getElementsByTagName("classname");
			
			$sclassidset=0;
			$sselected="selected";
			if(isset($_POST["s2classid"]))
			{
				$sclassidset=$_POST["s2classid"];
				$sselected = "";
			}
			echo '<h2>Select Class</h2>
			<form method="post" action="./home.php">';
			echo "Class:<select id='s2classid' name='s2classid'>";
			echo "<option value='' selected='".$sselected."'></option>";
			$sselected="";
			foreach($cids as $key=>$cid)
			{
				echo "<option value='".$cid->nodeValue."'>".$cnames->item($key)->nodeValue."</option>";
			}
			echo "</select>";
			echo "<input type='submit'>";
			echo "</form>";
			echo'</td>
			</tr>';
			
			echo'<tr>
			<td class="mytd" width=50%>
			<h2>Take Test</h2>
			<p>';
            
			if(isset($_POST["s2classid"]) && !empty($_POST["s2classid"]))
			{
				$result = curlcall(array('studentid' => urlencode($id),'classid' => urlencode($_POST['s2classid'])),"http://web.njit.edu/~ss55/490server/returnclasstest.php");
				$doc = new DOMDocument();
				$doc->loadHTML($result);
				$testids = $doc->getElementsByTagName('testid');
				$testnames = $doc->getElementsByTagName('testname');
				//echo "bye".$result."bye";
			echo '
				<form method ="post" action = "./taketest.php">
				<input name = "classid" value="'.$_POST["s2classid"].'" type="hidden">
				Select Test:<select name="testid">';
				foreach($testids as $key=>$testid)
				{
					echo "<option value='".$testid->nodeValue."'>".$testnames->item($key)->nodeValue."</option>";
				}
				echo'</select><input type = "submit">
				</form>';
			}
			echo'</p>
			</td>
			<td class="mytd" width=50%>
			<h2>Graded Tests</h2>';
			$results = curlcall(array("studentid"=>urlencode($id)),"http://web.njit.edu/~ss55/490server/returngradedtestlist.php");
			//echo $results;
			$doc = new DOMDocument();
			$doc->loadHTML($results);
			$gradedtids = $doc->getElementsByTagName("testid");
			$gradedtnames = $doc->getElementsByTagName("testname");
			$gcurscores = $doc->getElementsByTagName("curscore");
			echo '<form method="post" action="./viewtest.php">';
			
			echo'<input name = "classid" value="'.$_POST["s2classid"].'" type="hidden">
				Select Test:<select name="testid">';
				foreach($gradedtids as $key=>$gradedtid)
				{
					//if($gcurscore->item($key)->nodeValue!=0)
					{
						echo "<option value='".$gradedtid->nodeValue."'>".$gradedtnames->item($key)->nodeValue."</option>";
					}
				}
				echo'</select><input type = "submit">';
		
			echo "</form>";
			
			echo '</td>
			</tr>
			</table>
			';
        }
	}
?>
   
    </div>
<div>
<script>
$("#tbutton1").click(function(){
	$("#testform").attr("action", "./createtest.php").submit();
});
$("#tbutton2").click(function(){
	$("#tname").html("");
	$("#testform").attr("action", "./createtest.php").submit();
});
$("#studentselectclass").change(function(){
    //$("#mystudenttests")
});
</script>
</div>
</body>
</html>
