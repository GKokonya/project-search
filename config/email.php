<?php
require_once('phpmailer/phpmailer/src/Exception.php');
require_once('phpmailer/phpmailer/src/PHPMailer.php');
require_once('phpmailer/phpmailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email extends PHPMailer{
 
    private $host;
    private $security;
    private $port;
    private $username;
    private $password;
    private $noreply;
    
    public function __construct(){
        $this->host = "";
        $this->security = "ssl";
        $this->port = "465";
        $this->username = "";
        $this->password ="";
        $this->noreply = "";
        
    }
    
    //Function for sending email
    public function sendMail($addAddress,$subject,$body){
    //	try{
            $mail= new PHPMailer(true);
             /* Tells PHPMailer to use SMTP. */
            $mail->isSMTP();
    
    
             
            //$mail->SMTPDebug = 2;
             
            $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
            );
             
            /* SMTP server address. */
            $mail->Host=$this->host;
    
            /* Use SMTP authentication. */
            $mail->SMTPAuth=true;
    
            /* Use SMTP authentication. */
            $mail->SMTPSecure=$this->security;
    
             /* Set the SMTP port. */
            $mail->Port=$this->port;//Port 465
    
            $mail->isHTML(true);//Use HTML in body of email body
    
            /* SMTP authentication username. */
            $mail->Username=$this->username;//Your Mail
    
            /* SMTP authentication Password. */
            $mail->Password=$this->password;//Your Password
    
    
            $mail->setFrom($this->noreply);//Gmail Address which you used as SMTP Server
            
            /* Recipient Email Address */
            $mail->AddAddress($addAddress);//Email address of recipient 
    
            // Add a recipient
            $mail->addCC('georgekokonya@gmail.com');
            
            /* Subject for email sent to recipient */
            $mail->Subject=$subject;
    
            /* Actual message that is sent to Recipient */
            $mail->Body=$body;
    
             /* Finally send the mail. */
            if($mail->send()){
                return true;
            }else{
                return false;
            }
    }
}
?>