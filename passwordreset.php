<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

    <a href="web.njit.edu/~ll37/reset.php?u=username&c=code">Click here to reset</a>
    
<body>
<?php
require 'PHPMailer-master/PHPMailerAutoload.php';
$subject = 'Please Respond - One Attorney Per Area Only';
$message = "";
$headers = 'From: njitprojectmailer@gmail.com';
$list = array("");
//foreach($list as $to)
{
	//$to = 'pabobley@gmail.com';
//	mail($to,$subject,$message,$headers);
}
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
    $mail->Username = "njitprojectmailer@gmail.com"; // GMAIL username
    $mail->Password = "1qA2wS3eD4rF5tG6yH7uJ8iK9oL"; // GMAIL password
}

//Typical mail data
$mail->Subject = $subject;
$mail->Body = $message;

foreach($list as $to)
{
	//$to = 'pabobley@gmail.com';
 $mail->AddAddress($to);
 $mail->SetFrom("njitprojectmailer@gmail.com", "NJIT Project Password Reset");
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