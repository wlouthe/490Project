<?php
$server = "sql.njit.edu";
$user = "tjh24";
$pass = "senorita3";
$db = "tjh24";

// Create connect                                                                                                                                     
$con = mysqli_connect($server, $user, $pass, $db);
// Check connection                                                                                                                                   
if (mysqli_connect_errno()) {
    echo "MySQL Failed: ".mysqli_connect_error();
}

$AUTH = $_POST['auth'];  			// Authorization Code (0 or 1)
$USERNAME = $_POST['txtUCID'];    	// UCID
$PASSWORD = $_POST['txtPasswd'];  	// Encrypted Password
$CHANGEPW = $_POST['cpassword'];	// New password user wants changed
$EMAILSET = $_POST['txtUCID'];		// Email value that is posted

$query = mysqli_query($con,"SELECT * FROM login WHERE email = '$EMAILSET';");
$row = mysqli_fetch_array($query);
if ($AUTH == 1)
{
	if ($row['user'] == $USERNAME)
	{
		if (isset($CHANGEPW) && !empty($CHANGEPW))
		{
			$x = md5($USERNAME.time());
			$myquery="UPDATE login SET password = '$CHANGEPW', code = '$x', authentication = $AUTH WHERE user = '$USERNAME';";
			mysqli_query($con,$myquery);

			echo "<code>$x</code>";
			echo "<auth>1</auth>";
		}
		elseif ($PASSWORD == $row['password'])
		{
			$x = md5($USERNAME.time());
			mysqli_query($con,"UPDATE login SET code = '$x' WHERE user = '$USERNAME';");

			echo "<code>$x</code>";
			echo "<auth>1</auth>";
		}
		else
		{
			$x = md5($USERNAME.time());
			mysqli_query($con,"UPDATE login SET code = '$x' WHERE user = '$USERNAME';");

			echo "<code>$x</code>";
			echo "<auth>0</auth>";
		}
	}
	else
	{
		if (isset($CHANGEPW) && !empty($CHANGEPW))
		{
			$x = md5($USERNAME.time());
			mysqli_query($con,"INSERT INTO login (user, password, code, authentication) 
				VALUES ('$USERNAME','$CHANGEPW','$x','$AUTH');");
			echo "<code>$x</code>";
			echo "<auth>1</auth>";
		}
		else
		{
			$x = md5($USERNAME.time());
			mysqli_query($con,"INSERT INTO login (user, password, code, authentication) 
				VALUES ('$USERNAME','$PASSWORD','$x','$AUTH');");
			echo "<code>$x</code>";
			echo "<auth>1</auth>";
		}
	}
} 
else
{
	if (isset($EMAILSET) && $row['email'] == $EMAILSET) 
	{
		if (isset($row['password']) && $row['password'] == $PASSWORD) 
		{
			if (isset($CHANGEPW) && !empty($CHANGEPW) && strlen($CHANGEPW) > 7) 
			{
				$x = md5($USERNAME.time());

				mysqli_query($con,"UPDATE login SET password = '$CHANGEPW', code = '0' WHERE email = '$EMAILSET';");

				echo "<code>0</code>";
				echo "<auth>1</auth>";
			} 
			else
			{
				$x = md5($USERNAME.time());

				mysqli_query($con,"UPDATE login SET code = '$x' WHERE email = '$EMAILSET';");
					
				echo "<code>$x</code>";
				echo "<auth>1</auth>";
			}
		} 
		else
		{
			echo "<code>0</code>";
			echo "<auth>0</auth>";
		}
	}
	else
	{
		echo "<code>0</code>";
		echo "<auth>0</auth>";
	}
}

mysqli_close($con);
?>