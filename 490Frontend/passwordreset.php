<?php
	error_reporting(E_ALL);
	if(isset($_POST["username"]))
	{
		$url = "http://web.njit.edu/~ss55/490server/passwordreset.php";
		$fields = array(
			'txtUCID' => urlencode($_POST["username"])
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
		$passtype = $doc->getElementsByTagName('passtype')->item(0);
		if($passtype->nodeValue == "2")
		{
			$passtype = 2;
		}
		else if($passtype->nodeValue == "1")
		{
			$passtype = 1;
		}
		else $passtype = 0;
		$success = $doc->getElementsByTagName('success')->item(0);
		if($success->nodeValue == "2")
		{
			$success = 2;
		}
		else if($success->nodeValue == "1")
		{
			$success = 1;
		}
		else $success = 0;
	}
	else
	{
		$passtype=0;
		$success=0;
	}
?>
<html>
	<head>
	<script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<title>
			Password Reset Page
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
		if($success == 1)
		{
			echo "Success! <a href='index.php'>Please Login.</a>";
		}
		else
		{
			if(isset($_POST["username"]))
			{
				$myusername=$_POST["username"];
			}
			else
			{
				$myusername = "";
			}
			
			echo '
			<form name="login" id="myLogin" action="resetpassword.php" method="post">
				<table>
					<tr>
						<td>
						Email Address or UCID:
						</td><td>
						<input name="username" type="text" value="'. $myusername .'">
						</td>
					</tr>
					<tr>
						<td>
							<input id="mysubmit" type="submit" value="reset">
						</td>
					</tr>
				<script type="text/javascript">
				
				$(document).ready(function(){
				$( "#custompass" ).click(function(){
					$( "#custompass" ).slideUp();
					$( "#mysubmit" ).val("Change Password");
					$( "#cpw" ).html( "Current or UCID password:" );
					$( ".custompass2" ).show("slow", function(){});
					event.preventDefault();
					
				});
				$( "#custompass3" ).click(function(){
					$("#myLogin").attr("action","passwordreset.php");
					$( "#custompass3" ).hide();
					$( "#custompass4" ).show("slow", function(){});
					event.preventDefault();
					
				});
				});
				</script>
				</table>
			</form>
			';
		}
		?>
		</div>
	</body>
</html>

