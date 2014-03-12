<?php
require "mycurl.php";
if ( isset($_POST["testid"]) && isset($_POST["classid"]))
	{
		$url = "http://web.njit.edu/~tjh24/returntestquestion.php";
        $fields = array(
            'testid' => urlencode($_POST["testid"]),
            'classid' => urlencode($_POST["classid"])
		);
        $result = curlcall($fields,$url);
    
        $doc = new DOMDocument();
        $doc->loadHTML($result);
        
        $allquestions = $doc->getElementsByTagName('allquestions');
        $testquestions = $doc->getElementsByTagName('testquestions');
    
    
        $allquestionsids = $allquestions->item(0)->getElementsByTagName('id');
        $allquestionsnames = $allquestions->item(0)->getElementsByTagName('name');
        
        $testquestionsids = $testquestions->item(0)->getElementsByTagName('id');
    
        $tqarray = array();
        
        foreach($testquestionsids as $key => $tqid)
        {
           array_push($tqarray,$tqid->nodeValue);
        }
        $ct = count($tqarray);
        $index=0;
       
        foreach($allquestionsids as $key => $qid)
        {
            if($index!=$ct && $qid->nodeValue == $tqarray[$index])
            {
                $comp = 1;
                $index++;
            }
            else $comp = 0;
            echo "<id>".$qid->nodeValue."</id><name>".$allquestionsnames->item($key)->nodeValue."</name><ontest>".$comp."</ontest>";
        }
	}
?>