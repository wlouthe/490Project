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
           $teacherstudent = $doc->getElementsByTagName('teacherstudent')->item(0)->nodeValue;
           $id = $doc->getElementsByTagName('id')->item(0)->nodeValue;
			setcookie('mycode',$mykey,$expire,'/');
			$cookiechecker=1;
		}
		
	}

	if($cookiechecker==1)
	{
		if(isset($_POST["tname"]) && $_POST["tname"] != "")
		{
			$optionnum=1;
			//echo $_POST["tname"];
			$fields = array(
				"teachid" => urlencode($id),
				"classid" => urlencode($_POST["classid"]),
				"testname" => urlencode($_POST["tname"])
			);
			$result = curlcall($fields, "http://web.njit.edu/~ss55/490server/addtest.php");
			
			$doc = new DOMDocument();
			$doc->loadHTML($result);
			$testid = $doc->getElementsByTagName('testid')->item(0)->nodeValue;
			if($testid != "0")
			{
				//echo $testid;
			}
			else
			{
				header("Location: http://web.njit.edu/~ll37/home.php");
			}
		}
		elseif(isset($_POST["testid"]) && $_POST["testid"] != "0")
		{
			$optionnum=2;
			$fields = array(
				"testid" => urlencode($_POST["testid"])
			);
			$result = curlcall($fields, "http://web.njit.edu/~ss55/490server/returntestquestions.php");
			
			$doc = new DOMDocument();
			$doc->loadHTML($result);
			$testids = $doc->getElementsByTagName('testid');
			$testnames = $doc->getElementsByTagName('testid');
			
			foreach($testids as $key => $testid)
			{
				echo "<option value='".$testid->nodeValue."'>".$testnames->item($key)->nodeValue."</option>";
			}
			echo "</select>";
		}
		else
		{
			echo "id:".$id.":classid:".$_POST["classid"];
			$optionnum = 3;
			$fields = array(
				"teachid" => urlencode($id),
				"classid" => urlencode($_POST["classid"])
			);
			$result = curlcall($fields, "http://web.njit.edu/~ss55/490server/returntest.php");
			
			$doc = new DOMDocument();
			$doc->loadHTML($result);
			$testids = $doc->getElementsByTagName('testid');
			$testnames = $doc->getElementsByTagName('testname');
		}
		
/////////////////////////////////////////////////////////////////////////////
//// create html
/////////////////////////////////////////////////////////////////////////////
	echo '<head><link rel="stylesheet" href="mycss.css" type="text/css" media="screen">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script></head>
<body>
<div class="nav-wrapper">Welcome '. $uname .'! <a href="./logout.php">Logout?</a>
</div>
<div class="main-class">
<div class="mywindow">';
if ($optionnum==3)
{
	echo '<form id="myform" method="post" action="javascript: return false">
	<input name="myhid" value="123" type="hidden">
	<hr><div id="stestselect">';
	echo "Test:<select name = 'testid'><option value='0' selected='selected'></option>";
	foreach($testids as $key => $testid)
	{
		echo "<option value='".$testid->nodeValue."'>".$testnames->item($key)->nodeValue."</option>";
	}
	echo "</select></div><div id='ctestselect' style='display:none;'>Test Name:<input id='tname' name='tname' type='text'></div>";
	echo'<div id="qfields0"></div>
	<table><tr><td><button id="stest" class="submit">Select Test</button></td><td><button id="ctest">Create New Test</button></td></tr></table>
	<input id="mysub" type="submit">
	';

	echo '
	</form>
	<div>
	<script>
	$("#stest").click(function(){
		$("#tname").html("");
		$("#stestselect").show();
		$("#ctestselect").hide();
	});
	$("#ctest").click(function(){
		$("#tname").html("");
		$("#stestselect").hide();
		$("#ctestselect").show();
	});
	$("#mysub").click(function(){
		$("#myform").attr("action", "./createtest.php").submit();
	});
	</script></div>';
}

echo '</div></div></body>';

}
else
{
	echo '<meta http-equiv="refresh" content="1; url=index.php" /></head><body></body>';
}
?>

</html>
