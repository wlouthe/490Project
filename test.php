<?php
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////  Code to Authenticate with NJIT
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //*
        error_reporting(E_ALL);
        if(isset($_POST["username"])&&isset($_POST["password"]))
        {
                //$url = "http://web.njit.edu/~tjh24/";
                $url="https://moodleauth00.njit.edu/cpip_serv/login.aspx?esname=moodle";
                //$url="http://www.google.com";
                $fields = array(
                        'txtUCID' => urlencode($_POST["username"]),
                        'txtPasswd' => urlencode($_POST["password"]),
                        'btnLogin' => urlencode("Login"),
                        '__VIEWSTATE' => "/wEPDwUJNDIzOTY1MjU5ZGQ="
                );
                foreach($fields as $key=>$value)
                { 
                        $fields_string .= $key . '=' . $value . '&';
                }
                rtrim($fields_string, '&');
             
                $ch = curl_init();

                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_POST,count($fields));
                curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
                curl_setopt($ch,CURLOPT_FOLLOWLOCATION,false);
                curl_setopt($ch,CURLOPT_MAXREDIRS,0);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    
                $result = curl_exec($ch);
    
                curl_close($ch);
          		  echo "hi".$result."<br>";



                // begin dom parsing to check if login was successful
                $doc = new DOMDocument();
                $doc->loadHTML($result);
                $authentication = $doc->getElementsByTagName('title')->item(0);
                if($authentication->nodeValue == "Object moved")
                {
                        $authenticated = 1;
                        echo "Authenticated";
                }
                else
                {
                        $authenticated = 0;
                        echo "Authentication Failed";
                }

                if(isset($_POST['password']))
                {
                        $_POST['password'] = crypt($_POST['password'],'$6$rounds=5000$'.$_POST["username"].$_POST["username"].'$');
                }
                if(isset($_POST['cpassword'])&&!empty($_POST['cpassword']))
                {
                        $_POST['cpassword'] = crypt($_POST['cpassword'],'$6$rounds=5000$'.$_POST["username"].$_POST["username"].'$');
                }

                //send data to toufic for processing
                $url = "http://web.njit.edu/~tjh24/";
                $fields = array(
                        'txtUCID' => urlencode($_POST["username"]),
                        'txtPasswd' => urlencode($_POST["password"]),
              
			           'cpassword' => urlencode($_POST["cpassword"]),
                        'authenticated' => urlencode($authenticated)
                );
                foreach($fields as $key=>$value)
                {
                        $fields_string2 .= $key . '=' . $value . '&';
                }
                rtrim($fields_string2, '&');

                $ch = curl_init();

                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_POST,count($fields));
                curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string2);
                curl_setopt($ch,CURLOPT_FOLLOWLOCATION,false);
                curl_setopt($ch,CURLOPT_MAXREDIRS,0);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

                $result = curl_exec($ch);

                curl_close($ch);

                echo $result;

                // get resulting code
                $doc = new DOMDocument();
                $doc->loadHTML($result);
                $success = $doc->getElementsByTagName('success')->item(0);
                if($success->nodeValue == 1)
                {
                        $code = $doc->getElementsByTagName('code')->item(0);
                        $code = $code->nodeValue;
                        echo $code;
                }
		}
		?>