<html>
	<head>
	<?php
		echo '<meta http-equiv="refresh" content="3; url=index.php" />';
	?>
	<script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link rel="stylesheet" href="mycss.css" type="text/css" media="screen">
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
		</style
	></head>
	<body style="background-image:url(./img/grey_wash_wall/grey_wash_wall.png)">
		<div style="background-image:url(./img/triangular_@2X.png)">
		<?php
			if(isset($_COOKIE["mycode"]))
			{
				setcookie("mycode","",time()-3600,"/");
				echo '<div class="nav-wrapper"><ul class="navmenu"><li>Goodbye '.$uname.'!'."</li><li><a href='./index.php'><img src='./img/Home.png'></a></li></ul></div>";
			}
		?>
		
		</div>
	</body>
</html>

