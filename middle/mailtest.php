<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<?php
require 'PHPMailer-master/PHPMailerAutoload.php';
$subject = 'Please Respond - One Attorney Per Area Only';
// message goes here
$message = "";
//from email address goes here
$headers = 'From: ';
//list of addresses to mail to
$list = array("");

?>
<?php

$mail = new PHPMailer(true);
$send_using_gmail =true;
//Send mail using gmail
if($send_using_gmail){
    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->SMTPAuth = true; // enable SMTP authentication
    $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
    $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
    $mail->Port = 465; // set the SMTP port for the GMAIL server
    $mail->Username = ""; // GMAIL username
    $mail->Password = ""; // GMAIL password
}

//Typical mail data
$mail->Subject = $subject;
$mail->Body = $message;

foreach($list as $to)
{
	//$to = 'pabobley@gmail.com';
 $mail->AddAddress($to);
 $mail->SetFrom("", "");//gmail address, name i.e. wlouthe@gmail.com, 
 try{
    $mail->Send();
    echo "Success!";
 } catch(Exception $e){
    //Something went bad
    echo "Fail :(";
 }
 $mail->ClearAllRecipients();
 sleep(10);
}
?>
</body>
</html>