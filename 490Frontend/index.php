<?php

	error_reporting(E_ALL);
	$cookiechecker=0;
	$njitauthentication=0;
	$dbauthentication=0;
	if(isset($_COOKIE["mycode"]))
	{
		//echo "hello";
		$expire=time()+60*60;
		$mykey=$_COOKIE["mycode"];
		//echo $mykey;
		$url = "http://web.njit.edu/~ss55/490server/codechecker.php";
		//$url = "http://web.njit.edu/~tjh24/codechecker.php";
		$fields = array(
			'mycode' => urlencode($mykey)
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

		$coderesult = curl_exec($ch);

		curl_close($ch);
		
		//echo $coderesult;
		
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
			setcookie('mycode',$mykey,$expire,'/');
			$cookiechecker=1;
		}
		
	}
	if($cookiechecker!=1)
	{
		if(isset($_POST["username"])&&isset($_POST["password"]))
		{
			$_POST["username"] = htmlspecialchars($_POST["username"],ENT_QUOTES);
			$_POST["password"] = htmlspecialchars($_POST["password"],ENT_QUOTES);
			$url = "http://web.njit.edu/~ss55/490server/login.php";
			$fields = array(
				'txtUCID' => urlencode($_POST["username"]),
				'txtPasswd' => urlencode($_POST["password"]),
				'cpassword' => urlencode($_POST["cpassword"])
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
			
			//echo $result;
			
			// begin dom parsing to check if login was successful
			$doc = new DOMDocument();
			$doc->loadHTML($result);
			$authentication = $doc->getElementsByTagName('njitauthenticated')->item(0);
			$njitauthentication=$authentication->nodeValue;
			$authentication = $doc->getElementsByTagName('dbauthenticated')->item(0);
			$dbauthentication=$authentication->nodeValue;
			if($dbauthentication == "1" || $njitauthentication == "1")
			{
				$authentication = 1;
				
				//set cookie
				$expire=time()+60*60;
				$mykey = $doc->getElementsByTagName('code')->item(0)->nodeValue;
				$uname=$_POST['username'];
				setcookie('mycode',$mykey,$expire,'/');
				$cookiechecker=1;
				if($mykey == 0)
				{
					$cookiechecker=0;
					setcookie("mycode","",time()-3600,"/");
				}
			}
			else $authentication = 0;
		}
	}
	//*/
?>
<html>
	<head>
	<script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<title>
			Login Page
		</title>
		<style>
			body
			{
				margin:0 auto 0;
			}
			.custompass2
			{
				display:none;
			}
		</style>
	</head>
	<body style="background-image:url(./img/grey_wash_wall/grey_wash_wall.png)">
		<div style="background-image:url(./img/triangular_@2X.png)">
		<?php
			echo "<njitauthentication style='display:none'>".$njitauthentication."</njitauthentication><dbauthentication style='display:none'>".$dbauthentication."</dbauthentication>";
			if(isset($authentication))
			{
				if($authentication==1)
				{
					echo "<div style='color:green;'>Authenticated</div>";
				}
				else echo "<div style='color:red;'>Authentication Failed</div>";
			}
		?>
		<form name="login" id="myLogin" action="index.php" method="post" <?php if($cookiechecker==1){echo 'style="display:none;"';}  ?>>
			<table>
				<tr>
					<td>
					Email or UCID:
					</td><td>
					<input name="username" type="email" <?php if(isset($_POST["username"])) echo 'value="'.$_POST["username"].'"';?>>
					</td>
				</tr>
				<tr>
					<td id="cpw">
					Custom or UCID Password:
					</td><td>
					<input name="password" type="password">
					</td>
				</tr>
				<tr class="custompass2">
				<td class="custompass2">Enter your New Password Here:</td><td class="custompass2"><input class="custompass2" type="password" name="cpassword">
				</td>
				</tr>
				<tr>
					<td>
						<input id="mysubmit" type="submit" value="login">
					</td>
					<td>
						<table id="custompass">
						<tr>
						<td>
						<a href="signup.php" style="display:block; font-size:12px;">Signup</a>
						</td>
						</tr>
							<tr>
							<td>
							
						<a href="#" style="display:block; font-size:12px;">
							Change Password?
						</a>
						</td></tr>
						
						</table>
						<button id="custompass3" class="custompass2">
							Reset Password?
						</button>
						<button id="custompass4" style="display:none;">
							Confirm Reset?
						</button>
			<script type='text/javascript'>
			
			$(document).ready(function(){
			$( "#custompass" ).click(function(){
				$( "#custompass" ).slideUp();
				$( "#mysubmit" ).val("Change Password");
				$( "#cpw" ).html( "Current or UCID password:" );
				$( ".custompass2" ).show("slow", function(){});
				//event.preventDefault();
				
			});
			$( "#custompass3" ).click(function(){
				$("#myLogin").attr("action","passwordreset.php");
				$( "#custompass3" ).hide();
				$( "#custompass4" ).show("slow", function(){});
				event.preventDefault();
				
			});
			});
			</script>
				</td>			
				</tr>
			</table>
		</form>
		<?php if($cookiechecker==1){echo 'Welcome '.$uname.'! <a href="logout.php">Logout?</a>';}  ?>
		</div>
        <?php
            if($cookiechecker == 1)
            {
                echo "<div><a href='./home.php'>Home Page</a></div>";
            }
        ?>
	</body>
</html>

