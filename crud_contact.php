<?php
require_once('config/initialize.php');
$email=new Email();
//Instantiate Csrf class
$csrf=new Csrf();
?>
<!-- Custom JS function-->
<script type="text/javascript" src="js/function.js"></script>
<?php
$alert="";
if(isset($_POST['token'])){
    $post_token=htmlentities($_POST['token']);
    if($csrf->checkToken($post_token)){
        #First Name
        $firstname=htmlentities($_POST["first_name"]);
        
        #Last Name
        $lastname=htmlentities($_POST["last_name"]);
        
        #Email
        $myemail=htmlentities($_POST["email"]);
        
        #phonenumber
        $phonenumber=htmlentities($_POST["phone_number"]);
        
        #message
        $message=htmlentities($_POST["message"]);
        
        if(empty($firstname) || empty($lastname) || empty($myemail) || empty($phonenumber) || empty($myemail)){
            echo '<script>changePage("contact.php","Error! Please fill in the empty fields");</script>';
            
        }else{
        
            #Subject
            $subject="Contact";
            
            #email
            $sendEMail="gbkoks196@gmail.com";
            
            $body = "<html><body>"; 
            $body .= "<p>First Name :".$firstname  ."</p>";
            $body .= "<p>Last Name :".$lastname ."</p>";
            $body .= "<p>Email : ". $myemail ."</p>";
            $body .= "<p>Phone Number : ". $phonenumber ."</p>";
            $body .= "<p>Message : ". $message ."</p>";
            $body .= "</body></html>";
    
            if($email->sendMail($sendEMail,$subject,$body)){
                echo '<script>changePage("contact.php","Success! Thank you for contacting us!We will get in touch with you within 28 hours!");</script>';
                
            }else{
                echo '<script>changePage("contact.php","Error!Failed to send email!");</script>';
            }
        }
    }else{
        echo '<script>changePage("contact.php","Error!Invalid Token");</script>';
    }
}else{
    echo '<script>changePage("contact.php","Error!Invalid Request");</script>';
}
?>