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
		echo '<body>
		<div class="nav-wrapper">Welcome '. $uname .'!
		</div>
		<div class="main-class">
		<div class="mywindow">
		<form id="myform" method="post" action="./taketest.php">
		<input name="studentid" value="'.$id.'" type="hidden">
		<input name="username" value="'.$uname.'" type="hidden">
		<input name="testid" value="'.$_POST["testid"].'" type="hidden">
		<input name="classid" value="'.$_POST["classid"].'" type="hidden">
		<input name="submittest" value="1" type="hidden">
		<hr>';
		$results = curlcall(array("studentid" => urlencode($id),
									"testid" => urlencode($_POST["testid"]),
									"classid" => urlencode($_POST["classid"])),
									"http://web.njit.edu/~ss55/490server/returngradedtest.php");
		//<question>id, type, name</question>
		//echo $results;
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
			$sanswer = $question->getElementsByTagName("studentanswer")->item(0)->nodeValue;
			$canswer = $question->getElementsByTagName("correctanswer")->item(0)->nodeValue;
			$ansflag = $question->getElementsByTagName("ansflag")->item(0)->nodeValue;
			echo "<input name='questionid".$key."' value='".$qid."' type='hidden'><input class='type' name='type".$key."' value='".$type."' type='hidden'>";
			echo "<table><tr><td>Question ".($key+1).":</td>";
			if($ansflag==1)
			{
				echo"<td style='background-color:chartreuse'>Point Value: ".$pvalue."/".$pvalue."</td>";
			}
			else
			{
				echo"<td style='background-color:tomato'>Point Value: 0/".$pvalue."</td>";
			}
			echo "<td></td></tr>";
			echo "<tr><td></td><td>".$name."</td><td></td></tr>";
			if($type == 1)
			{
				$mycb1="";
				$mycb2="";
				$mycb3="";
				$mycb4=""; 
				$answer1 = $question->getElementsByTagName("ans")->item(0)->nodeValue;
				$answer2 = $question->getElementsByTagName("ans")->item(1)->nodeValue;
				$answer3 = $question->getElementsByTagName("ans")->item(2)->nodeValue;
				$answer4 = $question->getElementsByTagName("ans")->item(3)->nodeValue;
				switch($sanswer)
				{
					case $answer1:
						$mycb1 = "checked";
						if($sanswer != $canswer)
						{
							$mystyle1 = "style='background-color:tomato'";
						}
						break; 
					case $answer2:
						$mycb2 = "checked";
						if($sanswer != $canswer)
						{
							$mystyle2 = "style='background-color:tomato'";
						}
						break; 
					case $answer3:
						$mycb3 = "checked";
						if($sanswer != $canswer)
						{
							$mystyle3 = "style='background-color:tomato'";
						}
						break; 
					case $answer4:
						$mycb4 = "checked";
						if($sanswer != $canswer)
						{
							$mystyle4 = "style='background-color:tomato'";
						}
						break; 
				}
				switch($canswer)
				{
					case $answer1:
						$mystyle1 = "style='background-color:chartreuse'";
						break; 
					case $answer2:
						$mystyle2 = "style='background-color:chartreuse'";
						break; 
					case $answer3:
						$mystyle3 = "style='background-color:chartreuse'";
						break; 
					case $answer4:
						$mystyle4 = "style='background-color:chartreuse'";
						break; 
				}
				echo "<tr><td></td><td ".$mystyle1.">".$answer1."</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='1' disabled $mycb1></td></tr>";
				echo "<tr><td></td><td ".$mystyle2.">".$answer2."</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='2' disabled $mycb2></td></tr>";
				echo "<tr><td></td><td ".$mystyle3.">".$answer3."</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='3' disabled $mycb3></td></tr>";
				echo "<tr><td></td><td ".$mystyle4.">".$answer4."</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='4' disabled $mycb4></td></tr>";
			}
			if($type == 2)
			{
				if($ansflag == 1)
				{
					if($sanswer == 1)
					{
						echo "<tr><td></td><td style='background-color:chartreuse'>True</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='1' disabled checked></td></tr>";
						echo "<tr><td></td><td style='background-color:tomato'>False</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='2' disabled></td></tr>";
					}
					else
					{
						echo "<tr><td></td><td style='background-color:tomato'>True</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='1' disabled></td></tr>";
						echo "<tr><td></td><td style='background-color:chartreuse'>False</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='2' disabled checked></td></tr>";
					}
				}
				else
				{
					if($sanswer == 1)
					{
						echo "<tr><td></td><td style='background-color:tomato'>True</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='1' disabled checked></td></tr>";
						echo "<tr><td></td><td style='background-color:chartreuse'>False</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='2' disabled></td></tr>";
					}
					else
					{
						echo "<tr><td></td><td style='background-color:chartreuse'>True</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='1' disabled></td></tr>";
						echo "<tr><td></td><td style='background-color:tomato'>False</td><td><input id='answer".$key."' name='answer".$key."' type='radio' value='2' disabled checked></td></tr>";
						
					}
				}
			}
			if($type == 3)
			{
				if($ansflag == 1)
				{
					echo "<tr><td></td><td><input id='answer".$key."' name='answer".$key."' type='text' value='$sanswer' style='background-color:chartreuse' disabled></td><td style='background-color:chartreuse'>$canswer</td></tr>";
				}
				else
				{
					echo "<tr><td></td><td><input id='answer".$key."' name='answer".$key."' type='text' value='$sanswer' style='background-color:tomato' disabled></td><td style='background-color:chartreuse'>$canswer</td></tr>";
				}
			}
			if($type == 4)
			{
				if ($ansflag == 1)
				{	
					echo "<tr><td></td><td><textarea id='answer".$key."' name='answer".$key."' style='background-color:chartreuse' disabled>".$sanswer."</textarea></td><td></td></tr>";
				}
				else
				{
					echo "<tr><td></td><td><textarea id='answer".$key."' name='answer".$key."' style='background-color:tomato' disabled>".$sanswer."</textarea></td><td></td></tr>";
				}
			}
			echo "</table><hr>";
		}
		
		//*/
		echo '
		</form>
		<div>
	
		</div>';
		
		echo '</div></div></body>';
	}
else
{
	echo '<meta http-equiv="refresh" content="1; url=index.php" /></head><body></body>';
}
?>

</html>
