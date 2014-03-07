<?php
if(isset($_GET["UCID"]))
{
	echo "Hello ".$_GET["UCID"];
}
echo "<authenticated>true</authenticated>";
?>
