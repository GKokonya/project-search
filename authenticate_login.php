<?php
require_once('config/initialize.php');
$session = new Session();
$myuser = new User();
$csrf=new Csrf();
$utility=new Utility();
echo '<script type="text/javascript" src="js/function.js"></script>';
$message =  "";
if(isset($_POST['login'])){
    $post_token=htmlentities($_POST['token']);
    //Check for CSRF Token
    if($csrf->checkToken($post_token)){
       $email =  htmlentities($_POST['email']);
       $password =  htmlentities($_POST['password']);
       $login_user = $myuser->attempt_login($email,$password);
       
        if(empty($email) || empty($password)){
            echo '<script>changePage("login.php","Error! Please fill in the empty fields");</script>';
            
        }else{
           /**Check if the user is verified first */
            if ($login_user && $login_user['account_status'] == 0){  
                $session->message("Your account was locked! Please contact Administrator to unlock account");
                $utility->redirect_to("login.php");
                echo '<script>changePage("login.php","Your account was locked! Please contact Administrator to unlock account");</script>';
            }else{
                if ($login_user && $login_user['email_verified'] == 0){
                    echo '<script>changePage("login.php","Your email is not verified, Please verify email or Contact Administrator for assistant");</script>';
                }else{
                    if($login_user && $login_user['role'] == "administrator"){
                        //log time for you login
                        $myuser->setLastLogin($email);
                        $session->login($login_user);
                        echo '<script>changePage("administrator/index.php","Login Successful");</script>';
                    }else{
                        echo '<script>changePage("login.php","email/password combination incorrect");</script>';
                    }
                }
            }
        }
    }
    //Invalid or No CSRF Token
    else{ 
        echo '<script>changePage("login.php","INVALID CSRF TOKEN");</script>';
    }
}else{
    $email = "";
    $password = "";
}
?>