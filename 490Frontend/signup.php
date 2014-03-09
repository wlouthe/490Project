<?php
    require "mycurl.php";

	error_reporting(E_ALL);
	if(isset($_POST["username"])&&isset($_POST["password"])&&isset($_POST["cpassword"]))
	{
		$url = "http://web.njit.edu/~ss55/490server/signup.php";
		//$url = "http://web.njit.edu/~tjh24/signup.php";
		$fields = array(
			'txtEmail' => htmlspecialchars($_POST["username"],ENT_QUOTES),
			'txtPasswd' => htmlspecialchars($_POST["password"],ENT_QUOTES),
            'teacherstudent' => urlencode($_POST["teacherstudent"])
		);
		$result = curlcall($fields,$url);
		
		// begin dom parsing to check if login was successful
		$doc = new DOMDocument();
		$doc->loadHTML($result);
		$emailverification = $doc->getElementsByTagName('exists')->item(0);
		if($emailverification->nodeValue == "1" || empty($result))
		{
			$emailcd=0;
		}
		else
		{
			$emailcd=1;
		}
		
		
		if($_POST["password"]==$_POST["cpassword"] && strlen($_POST["password"])>7)
		{
			$passcd=1;
		}
		else
		{
			$passcd=0;
		}
	}
	else
	{
		$emailcd=2;
		$passcd=2;
	}
?>
<html>
	<head>
	<?php
	/*
		if($emailcd==1 && $passcd==1)
		{
			header("Location: index.php", TRUE, 303);
			exit;
		}
		*/
		if($emailcd==1 && $passcd==1)
		{
			//echo '<meta http-equiv="refresh" content="5; url=index.php" />';
		}
		echo "<email style='display:none;'>".$emailcd."</email>";
		echo "<password style='display:none;'>".$passcd."</password>";
	?>
	<link rel="stylesheet" href="mycss.css" type="text/css" media="screen">
	<script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<title>
			Login Page
		</title>
		<style>
			.custompass2
			{
				display:none;
				color:red;
				
			}
		</style
	</head>
	<body>
		<div class = "mywindow">
		<?php
		if($emailcd==1 && $passcd==1)
		{
			echo "Success! <a href='index.php'>Please Login.</a>";
		}
		?>
		<form name="login"  action="signup.php" method="post">
			<table>
				<tr>
					<td>Email Address:</td><td><input name="username" type="email" <?php if(isset($_POST["username"])) echo 'value="'.$_POST["username"].'"';?>></td>
				</tr>
				<tr>
					<td>Password:</td><td><input name="password" type="password"></td>
				</tr>
				<tr>
				<td>Confirm Password:</td><td><input type="password" name="cpassword">
				</td>
				</tr>
                <tr>
				<td>Student<input name="teacherstudent" type="radio" value="student" checked>Teacher<input name="teacherstudent" type="radio" value="teacher">
				</td>
				</tr>
				<tr>
					<td><input id="mysubmit" type="submit" value="sign up"></td><td><div id="alrtemail" class="custompass2">Invalid Email</div><div id="alrtpass" class="custompass2">Passwords dont match</div>
			<script type='text/javascript'>
			
			$(document).ready(function(){
			if($( "email" ).html() == "0")
			{
				$("#alrtemail").show();
			}
			if($( "password" ).html() == "0")
			{
				$("#alrtpass").show();
			}
			});
			</script>
				</td>			
				</tr>
			</table>
		</form>
		
		</div>
	</body>
</html>

