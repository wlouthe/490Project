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
		if(isset($_POST["testid"]))
		{
			$testid=$_POST["testid"];
		}
		if(isset($_POST["checkcb0"]))
		{
			//echo "optionnum:4:id:".$id.":classid:".$_POST["classid"];
			$result = curlcall($_POST, "http://web.njit.edu/~ss55/490server/addtestquestions.php");
			//echo $result;
			$doc = new DOMDocument();
			$doc->loadHTML($result);
			$success = $doc->getElementsByTagName('success')->item(0)->nodeValue;
			//echo $success;
		}
		
		$skipcode=0;
		if(isset($_POST["mode"]))
		{
			if($_POST["mode"]=="edit")
			{
				$skipcode=1;
			}
		}
		if(isset($_POST["tname"]) && $_POST["tname"] != "" && $skipcode==0)
		{
			//echo "optionnum:1:teachid:".$id.":classid:".$_POST["classid"].":testname:".$_POST["testname"];
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
				$optionnum=2;
				$fields = array(
					"testid" => urlencode($testid),
					"classid" => urlencode($_POST["classid"])
				);
				$result = curlcall($fields, "http://web.njit.edu/~ss55/490server/returntestquestions.php");
				$doc = new DOMDocument();
				$doc->loadHTML($result);
				$testids = $doc->getElementsByTagName('id');
				$testnames = $doc->getElementsByTagName('name');
				$ontest = $doc->getElementsByTagName('ontest');
			}
			else
			{
				header("Location: http://web.njit.edu/~ll37/home.php");
			}
		}
		elseif(isset($_POST["testid"]) && $_POST["testid"] != "0")
		{
			//echo "optionnum:2:testid:".$_POST["testid"].":classid:".$_POST["classid"];
			$optionnum=2;
			$testid=$_POST["testid"];
			$fields = array(
				"testid" => urlencode($_POST["testid"]),
				"classid" => urlencode($_POST["classid"])
			);
			$result = curlcall($fields, "http://web.njit.edu/~ss55/490server/returntestquestions.php");
			//echo $result;
			$doc = new DOMDocument();
			$doc->loadHTML($result);
			$testids = $doc->getElementsByTagName('id');
			$testnames = $doc->getElementsByTagName('name');
			$ontest = $doc->getElementsByTagName('ontest');
			
		}
		else
		{
			//header("Location: http://web.njit.edu/~ll37/home.php");
			//echo "optionnum:3:id:".$id.":classid:".$_POST["classid"];
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
if ($optionnum==2)
{
    echo '<table><tr><td>';
	echo '<form id="myform" method="post" action="./createtest.php">';
	echo '<input id="mode" name="mode" value="insert" type="hidden"><input name="testid" value="'.$testid.'" type="hidden"><input name="classid" value="'.$_POST['classid'].'" type="hidden"><input name="teachid" value="'.$id.'" type="hidden">';
	echo '<table class="mytable"><thead class="myhead"><tr><th>Question</th><th>On Test</th></tr></thead>';
	foreach($testids as $key => $testid)
	{
		//echo $ontest->item($key)->nodeValue;
		if($ontest->item($key)->nodeValue=="1")
		{
			$checked='checked';
		}
		else 
		{
			$checked='';
		}
		echo '<tr class="rowcolor'.(($key)%2).'"><td><input id="'.$testid->nodeValue.'" name="checkcb'.$key.'" type="hidden" value="1">'.$testnames->item($key)->nodeValue.'</td><td><input name="mycb'.$key.'" type="checkbox" value="'.$testid->nodeValue.'" '.$checked."></td></tr>";
	}
	echo '<tr><td></td><td><input type="submit"></td></tr></table></form></td><td><table class="mytable">';
    
    $fields = array(
        "teachid" => urlencode($id),
        "classid" => urlencode($_POST["classid"])
    );
    $result = curlcall($fields, "http://web.njit.edu/~ss55/490server/returntag.php");

    $doc = new DOMDocument();
    $doc->loadHTML($result);
    $tagnames = $doc->getElementsByTagName('tagid');
    
    foreach($tagnames as $key=>$tag)
    {
        echo '<tr class="rowcolor'.(($key)%2).'"><td>'.$tag->nodeValue.'</td><td><input id="tag'.$key.'" class="tag" type="checkbox" value="'.$tag->nodeValue.'"></td></tr>"';
    }
    
    echo '</table></td></tr></table>';
}
if ($optionnum==3)
{
	echo '<form id="myform" method="post" action="javascript: return false">
	<input id="mode" name="mode" value="edit" type="hidden">
	<input name="classid" value="'.$_POST["classid"].'" type="hidden">
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
		$("#mode").val("edit");
		$("#stestselect").show();
		$("#ctestselect").hide();
	});
	$("#ctest").click(function(){
		$("#tname").html("");
		$("#mode").val("new");
		$("#stestselect").hide();
		$("#ctestselect").show();
	});
	$("#mysub").click(function(){
		$("#myform").attr("action", "./createtest.php").submit();
	});
    $(".key").change(function(){
        var mytags = $(".key input:checkbox:checked").map(function(){
            return $(this).val();
        }).toArray();
        var tags = "";
        $.each(mytags,function(index,value){
            tags = tags + value + ",";
        });
        $.ajax({
            type: "POST",
            url: "http://web.njit.edu/~ss55/490server/tagfilter.php",
            data: {tagnames: tags}
        }).done(function(returnvals){
            alert(returnvals);
        });
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
