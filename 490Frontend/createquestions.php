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
		$test=curlcall($_POST,"http://web.njit.edu/~ss55/490server/addquestion.php");
/////////////////////////////////////////////////////////////////////////////
//// Run Program Start
/////////////////////////////////////////////////////////////////////////////
	echo '<head><link rel="stylesheet" href="mycss.css" type="text/css" media="screen">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script></head>
<body>
<div class="nav-wrapper">Welcome '. $uname .'!
</div>
<div class="main-class">
<div class="mywindow">
<form id="myform" method="post" action="javascript: return false">
<input name="myhid" value="123" type="hidden">
<hr>
<div id="qfields0"></div>
<table><tr><td><button id="multiplechoice" class="submit">Multiple Choice</button></td><td><button id="truefalse" class="submit">True or False</button></td><td><button id="shortanswer">Short Answer</button></td><td><button id="programming">Programming</button></td></tr></table>
<input id="mysub" type="submit">
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
<script>
var counter=0;
$("#multiplechoice").click(function(){
	var myscript = "<input class=\'longbox\' name=\'type"+counter+"\' type=\'hidden\' value=\'1\'><table><tr><td>Question:</td><td><input class=\'longbox\' name=\'question"+counter+"\' type=\'text\'></td></tr><tr><td>Answer:</td><td><input class=\'longbox\' name=\'answer1_"+counter+"\' type=\'text\'></td></tr><tr><td>Answer:</td><td><input class=\'longbox\' name=\'answer2_"+counter+"\' type=\'text\'></td></tr><tr><td>Answer:</td><td><input class=\'longbox\' name=\'answer3_"+counter+"\' type=\'text\'></td></tr><tr><td>Answer:</td><td><input class=\'longbox\' name=\'answer4_"+counter+"\' type=\'text\'></td></tr><tr><td>Correct Answer:</td><td><select name=\'correct"+counter+"\'><option value=\'1\' selected=\'selected\'>1</option><option value=\'2\'>2</option><option value=\'3\'>3</option><option value=\'4\'>4</option></select></td></tr><tr><td>Point Value:</td><td><input name=\'pvalue\' type=\'number\'></td></tr></table><hr></div><div id=\'qfields"+(counter+1)+"\'>";
	$("#qfields"+counter).html(myscript);
	counter++;
});
$("#mysub").click(function(){
	$("#myform").attr("action", "./createquestions.php").submit();
});
</script>
</div>';

echo '</div></div></body>';

}
else
{
	echo '<meta http-equiv="refresh" content="1; url=index.php" /></head><body></body>';
}
?>

</html>
