<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55401682-1', 'auto');
  ga('send', 'pageview', 'sendmail.php');

</script>

<?php
# request sent using HTTP_X_REQUESTED_WITH
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) AND ($_POST['url']=='')){
	if (isset($_POST['name']) AND isset($_POST['email']) AND isset($_POST['message'])) {
		$to = 'estudio@evolve.net.br';  // Change it by your email address
    $subject='Contato Estudio Evolve';
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message='';
    $phone = $_POST['phone'];
    if(!empty($phone)){
    $message='Telefone: '.$phone.'<br>';
    }
    $message .= "Nome:  $name<br>";
    $message .= "Email:  $email<br><br>";
    $message .= filter_var($_POST['message'], FILTER_SANITIZE_STRING);

		$sent = email($to, $email, $name, $subject, $message);
		if ($sent) {
			echo "<div class='content-message'> <i class='fa fa-rocket fa-3x'></i> <h2>Email Enviado com Sucesso</h2> <p>Sua mensagem foi enviada.</p> </div>";
		} else {
			echo "<div class='content-message'> <i class='fa fa-times fa-3x'></i> <h2>Erro ao Enviar Email</h2> <p>Tente novamente.</p> </div>";
		}
	}
	else {
		echo 'Todos os campos são obrigatórios';
	}
	return;
}

/**
 * email function
 *
 * @return bool | void
 **/
function email($to, $from_mail, $from_name, $subject, $message){
require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->From = $from_mail;
$mail->FromName = $from_name;
$mail->addAddress($to, 'Estudio Evolve');     // Add a recipient
$mail->addCC(''); //Optional ; Use for CC
$mail->addBCC('');//Optional ; Use for BCC

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->isHTML(true);                                  // Set email format to HTML


//Remove below comment out code for SMTP stuff, otherwise don't touch this code.
/*
$mail->isSMTP();
$mail->Host = "mail.example.com";  //Set the hostname of the mail server
$mail->Port = 25;  //Set the SMTP port number - likely to be 25, 465 or 587
$mail->SMTPAuth = true;  //Whether to use SMTP authentication
$mail->Username = "yourname@example.com"; //Username to use for SMTP authentication
$mail->Password = "yourpassword"; //Password to use for SMTP authentication
*/

$mail->Subject = $subject;
$mail->Body    = $message;
if($mail->send())return true;

}
?>


