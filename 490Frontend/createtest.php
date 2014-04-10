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
            $testtype = $doc->getElementsByTagName('type');
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
    echo '<table><thead></thead><tbody><tr><td>';
	echo '<form id="myform" method="post" action="./createtest.php">';
	echo '<input id="mode" name="mode" value="insert" type="hidden"><input name="testid" value="'.$testid.'" type="hidden"><input name="classid" value="'.$_POST['classid'].'" type="hidden"><input name="teachid" value="'.$id.'" type="hidden">';
	echo '<table class="mytable"><thead class="myhead"><tbody><tr><th>Question</th><th>On Test</th><th>Edit Question</th></tr></thead>';
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
<<<<<<< HEAD
		echo '<tr class="rowcolor'.(($key)%2).' '.$testid->nodeValue.' mytype'.$testtype->item($key)->nodeValue.' unhide"><input name="checkcb'.$key.'" type="hidden" value="'.$testtype->item($key)->nodeValue.'"><td class="'.$testid->nodeValue.'">'.$testnames->item($key)->nodeValue.'</td><td><input name="mycb'.$key.'" type="checkbox" value="'.$testid->nodeValue.'" '.$checked."></td><td style='background-color:tomato; color:whitesmoke;'><div style='height:100%; width:100%; background-color:tomato; color:whitesmoke;' id='".$testid->nodeValue."' class='editbutton'>Edit</div></td></tr>";
=======
		echo '<tr class="rowcolor'.(($key)%2).' '.$testid->nodeValue.' mytype'.$testtype->item($key)->nodeValue.' unhide"><td><input name="checkcb'.$key.'" type="hidden" value="'.$testtype->item($key)->nodeValue.'">'.$testnames->item($key)->nodeValue.'</td><td><input name="mycb'.$key.'" type="checkbox" value="'.$testid->nodeValue.'" '.$checked."></td><td><div style='height:100%; width:100%; background-color:tomato; color:whitesmoke;' id='edit".$key."' class='editbutton'>Edit</div></td></tr>";
>>>>>>> FETCH_HEAD
        //echo '<tr class="rowcolor'.(($key)%2).' edit'.$key.' myhide"><td>Question Name:</td><td><input id="qNameedit'.$key.'" type="text" value = "'.$testnames->item($key)->nodeValue.'"></td><td></td></tr>';
        //echo '<tr class="rowcolor'.(($key)%2).' edit'.$key.' myhide"><td>Option 1:</td><td><input id="qNameedit'.$key.'" type="text" value = "'.$testnames->item($key)->nodeValue.'"></td><td></td></tr>';
        //echo '<tr class="rowcolor'.(($key)%2).' edit'.$key.' myhide"><td>Option 2:</td><td><input id="qNameedit'.$key.'" type="text" value = "'.$testnames->item($key)->nodeValue.'"></td><td></td></tr>';
        //echo '<tr class="rowcolor'.(($key)%2).' edit'.$key.' myhide"><td>Question Name:</td><td><input id="qNameedit'.$key.'" type="text" value = "'.$testnames->item($key)->nodeValue.'"></td><td></td></tr>';
        //echo '<tr class="rowcolor'.(($key)%2).' edit'.$key.' myhide"><td>Question Name:</td><td><input id="qNameedit'.$key.'" type="text" value = "'.$testnames->item($key)->nodeValue.'"></td><td></td></tr>';
	}
	echo "<tr><td></td><td><input type='submit'></td></tr></tbody></table></form></td><td></td><td>";
    echo "<table class='mytable' style='display:block;'><thead class='myhead'><tr><th>Filter Tags</th><th>Show</th></tr></thead><tbody>";
    
    $fields = array(
        "teachid" => urlencode($id),
        "classid" => urlencode($_POST["classid"])
    );
    //echo $id;
    //echo $_POST["classid"];
    $result = curlcall($fields, "http://web.njit.edu/~ss55/490server/returntag.php");

    $doc = new DOMDocument();
    $doc->loadHTML($result);
    $tagnames = $doc->getElementsByTagName('tag');
    $finaltmp = 0;
    
    echo '<tr class="rowcolor0"><td>Multiple Choice</td><td><input id="tagmc" class="tag" type="checkbox" value="tagmc"></td></tr>';
    echo '<tr class="rowcolor1"><td>True/False</td><td><input id="tagtf" class="tag" type="checkbox" value="tagtf"></td></tr>';
    echo '<tr class="rowcolor0"><td>Open Ended</td><td><input id="tagop" class="tag" type="checkbox" value="tagop"></td></tr>';
    echo '<tr class="rowcolor1"><td>Coding</td><td><input id="tagcd" class="tag" type="checkbox" value="tagcd"></td></tr>';
    foreach($tagnames as $key=>$tag)
    {
        echo '<tr class="rowcolor'.(($key)%2).'"><td>'.$tag->nodeValue.'</td><td><input id="tag'.$key.'" class="tag" type="checkbox" value="'.$tag->nodeValue.'"></td></tr>';
        $finaltmp=$key;
    }
    
    echo '<tr class="rowcolor'.(($finaltmp+1)%2).'"><td>Search:</td><td><input id="searchbar" type="text"></td></tr><tr><td></td><td><button id="clearall">Clear All</button></td></tr></tbody></table></td></tr></tbody></table>';
    
    echo '<div>
	<script>
    $(document).ready(function(){
        var tid = '.$id.';
        var cid = '.$_POST["classid"].';
        $("input.tag").change(function(){
            //alert("funstart");
            var mytags = $("input.tag:checkbox:checked").map(function(){
                //alert("foundval");
                return $(this).val();
            }).toArray();
            var tags = "";
            var mycnt = 0;
            $("#searchbar").val("");
            $("tr.unhide").hide();
            $.each(mytags,function(index,value){
                //alert("InxVal" + index + ":" + value);
                if(value == "tagmc")
                {
                    $("tr.mytype1").show();
                }
                else if(value == "tagtf")
                {
                    $("tr.mytype2").show();
                }
                else if(value == "tagop")
                {
                    $("tr.mytype3").show();
                }
                else if(value == "tagcd")
                {
                    $("tr.mytype4").show();
                }
                else
                {
                    tags = tags + value + ",";
                }
                mycnt++;
            });
            $.ajax({
                type: "POST",
                url: "http://web.njit.edu/~ss55/490server/tagfilter.php",
                async: false,
                data: {
                    "teachid": tid,
                    "classid": cid,
                    "tagnames": tags
                },
                dataType: "xml",
                success: function(mydata,status,myobj){
                    $(mydata).find("qid").each(function(){
                        $("tr." + $(this).text()).show();
                    })

                },
                error: function(baba, gaga) {
                    alert("Error occured: " + gaga);
                }
            }).done(function(){
                //alert("done");
                //alert(mycnt);
                if(mycnt==0)
                {
                    $("tr.unhide").show();
                    
                }
            });
        });
        $("#searchbar").keyup(function(e){
            console.log( "Sending \'" + $(\'#searchbar\').val() + "\'");
            $("input.tag").prop("checked",false);
            $("tr.unhide").hide();
            $.ajax({
                type: "POST",
                url: "http://web.njit.edu/~ss55/490server/tagsearch.php",
                async: false,
                data: {
                    "teachid": tid,
                    "classid": cid,
                    "keyword": $("#searchbar").val()
                },
                dataType: "xml",
                success: function(mydata,status,myobj){
                    console.dirxml(mydata);
                    $(mydata).find("qid").each(function(){
                        console.log("hi" + $(this).text() + "bye");
                        $("tr." + $(this).text()).show();
                    })

                },
                error: function(baba, gaga) {
                    alert("Error occured: " + gaga);
                }
            }).done(function(){
                //alert("done");
                //alert(mycnt);
                if($("#searchbar").val() == "")
                {
                    $("tr.unhide").show();
                    
                }
            });
        });
        $("#clearall").click(function(){
            $("input.tag").prop("checked",false);
            $("#searchbar").val("");
            $("tr.unhide").show();
        });
        $("div.editbutton").click(function(e){
            console.log("Edit Clicked: " + $(this).attr("id"));
<<<<<<< HEAD
            if(lock == 1)
            {
                if(confirm("Would you like to discard your previous Edit?"))
                {
                    lock = 0;
                    $("input.tabltxt").val("");
                    $("select.tablselect").prop("selected",false);
                    $("textarea.tabltxtarea").val("");
                    $("#tr1").hide();
                    $("#tr2").hide();
                    $("#tr3").hide();
                    $("#tr4").hide();
                }
            }
            if(lock == 0)
            {
                lock = 1;
                var qid = $(this).attr("id");
                lastid = qid;
                
                $.ajax({
                    type: "POST",
                    url: "http://web.njit.edu/~ss55/490server/getQuestion.php",
                    async: false,
                    data: {
                        "id": lastid
                    },
                    dataType: "xml",
                    success: function(mydata,status,myobj){
                        console.dirxml(mydata);
                        console.log($(mydata).find("query").text());
                        var type = $(mydata).find("type").text();
                        last = type;
                        if(type == 1)
                        {
                            $("#tr1").show();
                            $("#tabl1q").val($(mydata).find("query").text());
                            $("#tabl1o1").val($(mydata).find("choice1").text());
                            $("#tabl1o2").val($(mydata).find("choice2").text());
                            $("#tabl1o3").val($(mydata).find("choice3").text());
                            $("#tabl1o4").val($(mydata).find("choice4").text());
                            $("#tabl1a").val($(mydata).find("correct").text());
                            $("#tabl1p").val($(mydata).find("pvalue").text());
                            var mytags = "";
                            $(mydata).find("tag").each(function(){
                                mytags = mytags + $(this).text() + ",";
                            });
                            $("#tabl1t").html(mytags);
                            $("#tabl1t").val(mytags);
                        }
                        if(type == 2)
                        {
                            $("#tr2").show();
                            $("#tabl2q").val($(mydata).find("query").text());
                            $("#tabl2a").val($(mydata).find("correct").text());
                            $("#tabl2p").val($(mydata).find("pvalue").text());
                            var mytags = "";
                            $(mydata).find("tag").each(function(){
                                mytags = mytags + $(this).text() + ",";
                            });
                            $("#tabl2t").html(mytags);
                            $("#tabl2t").val(mytags);
                        }
                        if(type == 3)
                        {
                            $("#tr3").show();
                            $("#tabl3q").val($(mydata).find("query").text());
                            $("#tabl3a").val($(mydata).find("answer").text());
                            $("#tabl3p").val($(mydata).find("pvalue").text());
                            var mytags = "";
                            $(mydata).find("tag").each(function(){
                                mytags = mytags + $(this).text() + ",";
                            });
                            $("#tabl3t").html(mytags);
                            $("#tabl3t").val(mytags);
                        }
                        if(type == 4)
                        {
                            $("#tr4").show();
                            $("#tabl4q").val($(mydata).find("query").text());
                            $("#tabl4o1").val($(mydata).find("case1").text());
                            $("#tabl4o2").val($(mydata).find("case2").text());
                            $("#tabl4o3").val($(mydata).find("case3").text());
                            $("#tabl4o4").val($(mydata).find("case4").text());
                            $("#tabl4a").val($(mydata).find("correct").text());
                            $("#tabl4p").val($(mydata).find("pvalue").text());
                            var mytags = "";
                            $(mydata).find("tag").each(function(){
                                mytags = mytags + $(this).text() + ",";
                            });
                            $("#tabl4t").html(mytags);
                            $("#tabl4t").val(mytags);
                        }
                    },
                    error: function(baba, gaga) {
                        alert("Error occured: " + gaga);
                    }
                });

                
            }
            
        });
        $("div.mysubmitter").click(function(){
            if(last == 1)
            {
                $.ajax({
                    type: "POST",
                    url: "http://web.njit.edu/~ss55/490server/editQuestion.php",
                    async: false,
                    data: {
                        "teacherid": '.$id.',
                        "classid": '.$_POST["classid"].',
                        "id": lastid,
                        "type":last,
                        "question": $("#tabl1q").val(),
                        "answer1_": $("#tabl1o1").val(),
                        "answer2_": $("#tabl1o2").val(),
                        "answer3_": $("#tabl1o3").val(),
                        "answer4_": $("#tabl1o4").val(),
                        "correct": $("#tabl1a").val(),
                        "pvalue": $("#tabl1p").val(),
                        "tags": $("#tabl1t").val()
                    },
                    dataType: "xml",
                    success: function(mydata,status,myobj){
                        console.log("success");
                        console.dirxml(mydata);
                        console.log($("#tabl1t").val());
                        $("td."+lastid).html($("#tabl1q").val());
                    },
                    error: function(baba, gaga) {
                        alert("Error occured: " + gaga);
                    }
                }).done(function(){
                    alert("Success!");
                });
            }
            if(last == 2)
            {
                $.ajax({
                    type: "POST",
                    url: "http://web.njit.edu/~ss55/490server/editQuestion.php",
                    async: false,
                    data: {
                        "teacherid": '.$id.',
                        "classid": '.$_POST["classid"].',
                        "id": lastid,
                        "type":last,
                        "question": $("#tabl2q").val(),
                        "correct": $("#tabl2a").val(),
                        "pvalue": $("#tabl2p").val(),
                        "tags": $("#tabl2t").val()
                    },
                    dataType: "xml",
                    success: function(mydata,status,myobj){
                        console.log("success");
                        console.dirxml(mydata);
                        console.log($("#tabl2t").val());
                        $("td."+lastid).html($("#tabl2q").val());
                    },
                    error: function(baba, gaga) {
                        alert("Error occured: " + gaga);
                    }
                });
            }
            if(last == 3)
            {
                $.ajax({
                    type: "POST",
                    url: "http://web.njit.edu/~ss55/490server/editQuestion.php",
                    async: false,
                    data: {
                        "teacherid": '.$id.',
                        "classid": '.$_POST["classid"].',
                        "id": lastid,
                        "type":last,
                        "question": $("#tabl3q").val(),
                        "correct": $("#tabl3a").val(),
                        "pvalue": $("#tabl3p").val(),
                        "tags": $("#tabl3t").val()
                    },
                    dataType: "xml",
                    success: function(mydata,status,myobj){
                        console.log("success");
                        console.dirxml(mydata);
                        console.log($("#tabl3t").val());
                        $("td."+lastid).html($("#tabl3q").val());
                    },
                    error: function(baba, gaga) {
                        alert("Error occured: " + gaga);
                    }
                });
            }
            if(last == 4)
            {
                $.ajax({
                    type: "POST",
                    url: "http://web.njit.edu/~ss55/490server/editQuestion.php",
                    async: false,
                    data: {
                        "teacherid": '.$id.',
                        "classid": '.$_POST["classid"].',
                        "id": lastid,
                        "type":last,
                        "question": $("#tabl4q").val(),
                        "testcase1_": $("#tabl4o1").val(),
                        "testcase2_": $("#tabl4o2").val(),
                        "testcase3_": $("#tabl4o3").val(),
                        "testcase4_": $("#tabl4o4").val(),
                        "testcode": $("#tabl4a").val(),
                        "pvalue": $("#tabl4p").val(),
                        "tags": $("#tabl4t").val()
                    },
                    dataType: "xml",
                    success: function(mydata,status,myobj){
                        console.log("success");
                        console.dirxml(mydata);
                        console.log($("#tabl4t").val());
                        $("td."+lastid).html($("#tabl4q").val());
                    },
                    error: function(baba, gaga) {
                        alert("Error occured: " + gaga);
                    }
                });
            }
            lock=0;
            $("input.tabltxt").val("");
            $("select.tablselect").prop("selected",false);
            $("textarea.tabltxtarea").val("");
            $("#tr1").hide();
            $("#tr2").hide();
            $("#tr3").hide();
            $("#tr4").hide();
        });
        
        $("div.mydisregarder").click(function(){
            lock=0;
            $("input.tabltxt").val("");
            $("select.tablselect").prop("selected",false);
            $("textarea.tabltxtarea").val("");
            $("#tr1").hide();
            $("#tr2").hide();
            $("#tr3").hide();
            $("#tr4").hide();
=======
>>>>>>> FETCH_HEAD
        });
    });
	</script></div>';
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
