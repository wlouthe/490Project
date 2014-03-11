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
		if(isset($_POST["type0"]))
		{
			$test=curlcall($_POST,"http://web.njit.edu/~ss55/490server/addquestion.php");
		}
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
	var myscript = "Multiple Choice<br><input class=\'longbox\' name=\'type"+counter+"\' type=\'hidden\' value=\'1\'><table><tr><td>Question:</td><td><input class=\'longbox\' name=\'question"+counter+"\' type=\'text\'></td></tr><tr><td>Answer:</td><td><input class=\'longbox\' name=\'answer1_"+counter+"\' type=\'text\'></td></tr><tr><td>Answer:</td><td><input class=\'longbox\' name=\'answer2_"+counter+"\' type=\'text\'></td></tr><tr><td>Answer:</td><td><input class=\'longbox\' name=\'answer3_"+counter+"\' type=\'text\'></td></tr><tr><td>Answer:</td><td><input class=\'longbox\' name=\'answer4_"+counter+"\' type=\'text\'></td></tr><tr><td>Correct Answer:</td><td><select name=\'correct"+counter+"\'><option value=\'1\' selected=\'selected\'>1</option><option value=\'2\'>2</option><option value=\'3\'>3</option><option value=\'4\'>4</option></select></td></tr><tr><td>Point Value:</td><td><input name=\'pvalue\' type=\'number\'></td></tr></table><hr></div><div id=\'qfields"+(counter+1)+"\'>";
	$("#qfields"+counter).html(myscript);
	counter++;
});
$("#truefalse").click(function(){
	var myscript = "True/False<br><input class=\'longbox\' name=\'type"+counter+"\' type=\'hidden\' value=\'2\'><table><tr><td>Question:</td><td><input class=\'longbox\' name=\'question"+counter+"\' type=\'text\'></td></tr><tr><td>Correct Answer:</td><td><select name=\'correct"+counter+"\'><option value=\'1\' selected=\'selected\'>True</option><option value=\'2\'>False</option></select></td></tr><tr><td>Point Value:</td><td><input name=\'pvalue\' type=\'number\'></td></tr></table><hr></div><div id=\'qfields"+(counter+1)+"\'>";
	$("#qfields"+counter).html(myscript);
	counter++;
});
$("#shortanswer").click(function(){
	var myscript = "Short Answer<br><input class=\'longbox\' name=\'type"+counter+"\' type=\'hidden\' value=\'3\'><table><tr><td>Question:</td><td><input class=\'longbox\' name=\'question"+counter+"\' type=\'text\'></td></tr><tr><td>Correct Answer:</td><td><input name=\'correct"+counter+"\' type=\'text\'></td></tr><tr><td>Point Value:</td><td><input name=\'pvalue\' type=\'number\'></td></tr></table><hr></div><div id=\'qfields"+(counter+1)+"\'>";
	$("#qfields"+counter).html(myscript);
	counter++;
});
$("#programming").click(function(){
	var myscript = "Test Cases should be an equivilance (i.e. if your question is \"create a function add2 to add and return 2 numbers together\", then your equivilence case should be \"add2(3,4) == 7\")<br>Test Code area should be used for creating functions that the students code can be tested against. This isn\'t required but allows for more intricate tests.<br><input class=\'longbox\' name=\'type"+counter+"\' type=\'hidden\' value=\'4\'><table><tr><td>Question:</td><td><input class=\'longbox\' name=\'question"+counter+"\' type=\'text\'></td></tr><tr><td>Test Case 1:</td><td><input class=\'longbox\' name=\'testcase1_"+counter+"\' type=\'text\'></td></tr><tr><td>Test Case 2:</td><td><input class=\'longbox\' name=\'testcase2_"+counter+"\' type=\'text\'></td></tr><tr><td>Test Case 3:</td><td><input class=\'longbox\' name=\'testcase3_"+counter+"\' type=\'text\'></td></tr><tr><td>Test Case 4:</td><td><input class=\'longbox\' name=\'testcase4_"+counter+"\' type=\'text\'></td></tr><tr><td>Test Code:</td><td><textarea name=\'testcode"+counter+"\'></textarea></td></tr><tr><td>Point Value:</td><td><input name=\'pvalue\' type=\'number\'></td></tr></table><hr></div><div id=\'qfields"+(counter+1)+"\'>";
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
