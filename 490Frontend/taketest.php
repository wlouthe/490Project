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

	if($cookiechecker==1 && $teacherstudent == 0)
	{
		
		//echo $_POST["classes"];
/////////////////////////////////////////////////////////////////////////////
//// Run Program Start
/////////////////////////////////////////////////////////////////////////////
	echo '<head><link rel="stylesheet" href="mycss.css" type="text/css" media="screen">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script></head>';
	if(isset($_POST["submittest"]))
	{
		$result = curlcall("http://web.njit.edu/~ss55/490server/.php");
	}
	if(isset($_POST["starttest"]))
	{
		
		echo '<body>
		<div class="nav-wrapper">Welcome '. $uname .'!
		</div>
		<div class="main-class">
		<div class="mywindow">
		<div id="timefield"><h2>Time Remaining:</h2><h2 id="currenttime"></h2></div>
		<form id="myform" method="post" action="javascript: return false">
		<input name="studentid" value="'.$id.'" type="hidden">
		<input name="testid" value="'.$_POST["testid"].'" type="hidden">
		<input name="classid" value="'.$_POST["classid"].'" type="hidden">
		<input name="submittest" value="1" type="hidden">
		<hr>';
		$results = curlcall(array("studentid" => urlencode($id),
									"testid" => urlencode($_POST["testid"]),
									"classid" => urlencode($_POST["classid"])),
									"http://web.njit.edu/~ss55/490server/generatetest.php");
		//<question>id, type, name</question>
		$doc = new DOMDocument();
		$doc->loadHTML($results);
		$starttime = $doc->getElementsByTagName("timestart")->item(0)->nodeValue;
		$endtime = $doc->getElementsByTagName("timeend")->item(0)->nodeValue;
		echo "<div id='stime' style='display:none;'>".$starttime."</div>";
		echo "<div id='etime' style='display:none;'>".$endtime."</div>";
		$questions = $doc->getElementsByTagName("question");
		foreach($questions as $key=>$question)
		{
			$qid = $question->getElementsByTagName("id")->item(0)->nodeValue;
			$type = $question->getElementsByTagName("type")->item(0)->nodeValue;
			$name = $question->getElementsByTagName("name")->item(0)->nodeValue;
			$pvalue = $question->getElementsByTagName("pvalue")->item(0)->nodeValue;
			echo "<input name='questionid".$key."' value='".$qid."' type='hidden'><input name='type".$key."' value='".$type."' type='hidden'>";
			echo "<table><tr><td>Question ".($key+1).":</td><td>Point Value: ".$pvalue."</td><td></td></tr>";
			echo "<tr><td></td><td>".$name."</td><td></td></tr>";
			if($type == 1)
			{
				$answer1 = $question->getElementsByTagName("A")->item(0)->nodeValue;
				$answer2 = $question->getElementsByTagName("B")->item(0)->nodeValue;
				$answer3 = $question->getElementsByTagName("C")->item(0)->nodeValue;
				$answer4 = $question->getElementsByTagName("D")->item(0)->nodeValue;
				echo "<tr><td></td><td>".$answer1."</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='1'></td></tr>";
				echo "<tr><td></td><td>".$answer2."</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='2'></td></tr>";
				echo "<tr><td></td><td>".$answer3."</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='3'></td></tr>";
				echo "<tr><td></td><td>".$answer4."</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='4'></td></tr>";
			}
			if($type == 2)
			{
				echo "<tr><td></td><td>True</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='1'></td></tr>";
				echo "<tr><td></td><td>False</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='0'></td></tr>";
			}
			if($type == 3)
			{
				echo "<tr><td></td><td><input id='answer".$key."' name='answer".$key."' type='text'></td><td></td></tr>";
			}
			if($type == 4)
			{
				echo "<tr><td></td><td><textarea id='answer".$key."' name='answer".$key."'></textarea></td><td></td></tr>";
			}
			echo "</table><hr>";
		}
		echo '<input id="mysub" type="submit">
		';
		//*/
		echo '
		</form>
		<div>
		<script>
		
		var sdatetxt = $("#stime").html().split(/[- :]/);
		var edatetxt = $("#etime").html().split(/[- :]/);
		var sdate = new Date(sdatetxt[0],sdatetxt[1]-1,sdatetxt[2],sdatetxt[3],sdatetxt[4],sdatetxt[5]);
		var edate = new Date(edatetxt[0],edatetxt[1]-1,edatetxt[2],edatetxt[3],edatetxt[4],edatetxt[5]);
		var cdate;
		var hours;
		var minutes;
		var seconds;
		
		$(document).ready(function(){
			$("#timefield").css({marginLeft : ($(window).width()-$("#timefield").width() + 20)});
		});
		
		setTimeout(function(){
			$("#timefield").css({marginLeft : ($(window).width()-$("#timefield").width() + 20)});
		},
		1000);
		
		setInterval(function(){
			cdate = (edate - new Date);
			cdate = (cdate - (cdate%1000))/1000;
			hours = (cdate-(cdate%3600))/3600;
			minutes = ((cdate-hours*3600) - (cdate-hours*3600)%60)/60;
			seconds  = (cdate-hours*3600-minutes*60);
			$("#currenttime").html(hours+":"+minutes+":"+seconds);
			
		},
		1000);
		
	
		$(window).resize(function(){	
			$("#timefield").css({marginLeft : ($(window).width()-$("#timefield").width() + 20)});
		});
		
		
		
		</script>
		</div>';
		
		echo '</div></div></body>';
	}
	else
	{
		echo '<body><div class="nav-wrapper">Welcome '. $uname .'!
		</div>
		<div class="main-class">
		<div class="mywindow"><form method="post" action="./taketest.php"><input name="starttest" value="1" type="hidden"><input name="testid" value="'.$_POST["testid"].'" type="hidden"><input name="classid" value="'.$_POST["classid"].'" type="hidden">Confirm Start Test?<br><input type="submit"></form>';
		
		echo '</div></div></body>';
	}

}
else
{
	echo '<meta http-equiv="refresh" content="1; url=index.php" /></head><body></body>';
}
?>

</html>
