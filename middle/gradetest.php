<?php
require "mycurl.php";


if(isset($_POST["studentid"]) && isset($_POST["testid"]))
{
    foreach($_POST as $key => $mypost)
    {
         $_POST[$key] = rawurldecode($_POST[$key]);
    }
    
	$count = 0;
    $username = $_POST["username"];
    while(isset($_POST["questionid".$count]))
    {
        
		$correct = 0;
		if( $_POST["type".$count] == 1 || $_POST["type".$count] == 2 || $_POST["type".$count] == 3 )
		{
            
            $fields = array(
				'questionid' => urlencode($_POST["questionid".$count]),
                'type' => urlencode($_POST["type".$count])
			
			);
            
            
            $result = curlcall($fields,"http://web.njit.edu/~tjh24/returnanswer.php");
            
            $doc = new DOMDocument();
            $doc->loadHTML($result);
            $answer = $doc->getElementsByTagName("answer")->item(0)->nodeValue;
			if(isset($_POST["answer".$count]) && !empty($answer) && isset($_POST["type".$count]))
			{			
                
				if ($_POST["answer".$count] == $answer)
				{
                    echo "correct found";
					$correct = 1;
				}
                else "notfound";
			}
            
            $fields = array(
                'testid' => urlencode($_POST["testid"]),
                'studentid' => urlencode($_POST["studentid"]),
                'questionid' => urlencode($_POST["questionid".$count]),
                'answer' => urlencode($_POST["answer".$count]),
                'correct' => urlencode($correct),
                'type' => urlencode($_POST["type".$count])
                );
            $result = curlcall($fields,"http://web.njit.edu/~tjh24/storestudenttest.php");
            
		
		}
		if( $_POST["type".$count] == 4)
		{
            $fields = array(
				'questionid' => urlencode($_POST["questionid".$count]),
                'type' => urlencode($_POST["type".$count])
			
			);
            
            $result = curlcall($fields,"http://web.njit.edu/~tjh24/returnanswer.php");
            $doc = new DOMDocument();
            $doc->loadHTML($result);
            $tcode = $doc->getElementsByTagName("teachercode")->item(0)->nodeValue;
            $test1 = $doc->getElementsByTagName("testcode1")->item(0)->nodeValue;
            $test2 = $doc->getElementsByTagName("testcode1")->item(1)->nodeValue;
            $test3 = $doc->getElementsByTagName("testcode1")->item(2)->nodeValue;
            $test4 = $doc->getElementsByTagName("testcode1")->item(3)->nodeValue;
            if(isset($_POST["answer".$count])&&!empty($_POST["answer".$count]))
            {
                system('rm ./codebin/'.$username."_".$_POST['testid']."_".$_POST['questionid'.$count].".py");
                system('rm ./codebin/'.$username."_".$_POST['testid']."_".$_POST['questionid'.$count].'.txt');
                system('rm ./codebin/'.$username."_".$_POST['testid']."_".$_POST['questionid'.$count].'error.txt');
                $mytcvars="";
                if(empty($testcase1))
                {
                    $mytcvars=$mytcvars."\r\ntestcase1 = 1";
                }
                else
                {
                    $mytcvars=$mytcvars."\r\ntestcase1 = 0\r\nif ".$test1.":\r\n\ttestcase1 = 1";
                }
                if(empty($testcase2))
                {
                    $mytcvars=$mytcvars."\r\ntestcase2 = 1";
                }
                else
                {
                    $mytcvars=$mytcvars."\r\ntestcase2 = 0\r\nif ".$test2.":\r\n\ttestcase2 = 1";
                }
                if(empty($testcase3))
                {
                    $mytcvars=$mytcvars."\r\ntestcase3 = 1";
                }
                else
                {
                    $mytcvars=$mytcvars."\r\ntestcase3 = 0\r\nif ".$test3.":\r\n\ttestcase3 = 1";
                }
                if(empty($testcase4))
                {
                    $mytcvars=$mytcvars."\r\ntestcase4 = 1";
                }
                else
                {
                    $mytcvars=$mytcvars."\r\ntestcase4 = 0\r\nif ".$test4.":\r\n\ttestcase4 = 1";
                }
                $mytcvars=$mytcvars."\r\ntestcount = testcase1*1000 + testcase2*100 + testcase3*10 + testcase4";
                $mycode = "\r\nf = open('/afs/cad/u/s/s/ss55/public_html/490server/codebin/".$username."_".$_POST['testid']."_".$_POST['questionid'.$count].".txt','w')".$mytcvars."\r\nf.write(str(testcount))";
            
                $handle = fopen("./codebin/".$username."_".$_POST['testid']."_".$_POST['questionid'.$count].".py","c");
                fwrite($handle, $tcode."\r\n".$_POST["answer".$count].$mycode);
                fclose($handle);
            
                
                $cmd = 'python ./codebin/'.$username."_".$_POST['testid']."_".$_POST['questionid'.$count].'.py';
                
                
                $descriptorspec = array(
                0 => array("pipe","r"),
                1 => array("pipe","w"),
                2 => array("file", "./codebin/".$username."_".$_POST['testid']."_".$_POST['questionid'.$count]."error.txt","a")
                );
                $cwd = "./codebin/";
                $process = proc_open('python /afs/cad/u/s/s/ss55/public_html/490server/codebin/'.$username."_".$_POST['testid']."_".$_POST['questionid'.$count].'.py',$descriptorspec,$pipes);
                if(is_resource($process))
                {
                    
                    $programrunning = stream_get_contents($pipes[1]);
                    fclose($pipes[1]);
                    proc_close($process);
                    //if (!empty($programrunning))
                    {
                        
                        //echo $programrunning;
                        $handle2 = fopen("./codebin/".$username."_".$_POST['testid']."_".$_POST['questionid'.$count].".txt","r");
                        $mystring2 = fread($handle2,filesize("./codebin/".$username."_".$_POST['testid']."_".$_POST['questionid'.$count].".txt"));
                        echo $mystring2;
                        if ($mystring2 == "1111")
                        {
                             $correct = 1;
                        }
                        fclose($handle2);
                    }
                    // else
                     {
                        /*
                        echo "CHEENIS";
                        $handle2 = fopen("./codebin/".$username."_".$_POST['testid']."_".$_POST['questionid'.$count]."error.txt","r");
                        $mystring3 = fread($handle2,filesize("./codebin/".$username."_".$_POST['testid']."_".$_POST['questionid'.$count]."error.txt"));
                        fclose($handle2);
                        echo $mystring3;
                        */
                    }
                }
                
                
                
                $fields = array(
                    'testid' => urlencode($_POST["testid"]),
                    'studentid' => urlencode($_POST["studentid"]),
                    'questionid' => urlencode($_POST["questionid".$count]),
                    'answer' => urlencode("/afs/cad/u/s/s/ss55/public_html/490server/codebin/".$username."_".$_POST['testid']."_".$_POST['questionid'.$count].".py"),
                    'correct' => urlencode($correct),
                    'type' => urlencode($_POST["type".$count])
                    );
                $result = curlcall($fields,"http://web.njit.edu/~tjh24/storestudenttest.php");
		
            }
				
		}
        $count++;    
    }
    echo "<success>1</success>";
}
?>