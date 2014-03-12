<?php
require "mycurl.php";
$url = "http://web.njit.edu/~tjh24/gradetest.php";
if(isset($_POST["studentid"]) && isset($_POST["testid"]))
{
	$count = 0;
    while(isset($_POST["questionid".$count]))
    {
		$correct = 0;
		if( $_POST["type".$count]) == 1 || $_POST["type".$count]) == 2 || $_POST["type".$count]) == 3 )
		{
			if(isset($_POST["answer".$count]) && isset($_POST["studentanswer".$count]) && isset($_POST["type".$count]))
			{			
				if ($_POST["answer".$count]) == $_POST["studentanswer".$count])
				{
					$correct = 1;
				}
			}
		}
		if( $_POST["type".$count]) == 4)
		{
			if(isset($_POST["studentid"]) && isset($_POST["testid"]))
			{
			
			
			
			}
				
		}
			
		$fields = array(
			'testid' => urlencode($_POST["testid"]),
			'studentid' => urlencode($_POST["studentid"]),
			'questionid' => urlencode($_POST["questionid".$count]),
			'correct' => urlencode($correct)
			);
		$result = curlcall($fields,$url);
		
		$doc = new DOMDocument();
		$doc->loadHTML($result);
	
		$success = $doc->getElementsByTagName('success')->item(0)->nodeValue * $success;
        
        $count++;    
    }
    echo "<success>".$success."</success>";
}
?>