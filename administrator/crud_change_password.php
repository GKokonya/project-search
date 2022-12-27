<?php
require_once('../config/initialize.php');
$session=new Session();
$userObj=new User();
$csrf=new Csrf();

//define page role
define("ROLE","administrator");
//get the user session role 
$role = $session->role;
//if the role does not match the user he/she is taken back to login page
$session->checkRole($role,ROLE);
$user_id=$userObj->getByID($session->user_id);
?>
<!-- Custom JS function-->
<script type="text/javascript" src="../js/function.js"></script>
<?php
/*=====================START OF UPDATE USER PASSWORD===========================*/
if(isset($_POST['token']) && isset($_POST['change_passsword'])){
    $token=htmlentities($_POST['token']);
    if($csrf->checkToken($token)){

        $userObj->setId(htmlentities($_POST["user_id"]));
        $hashed_password = $userObj->password_encrypt(htmlentities($_POST["password"]));
        $userObj->setPassword($hashed_password);
        if($userObj->updatePassword()){
            echo "<script> changePage('change_password.php','Password changed successfully') </script>";

        }else{
            echo "<script> changePage('change_password.php','Failed to change Password') </script>";
        }
        
    }else{
            echo "<script>
         changePage('change_password.php','Error! Invalid token!');
         </script>";
        
    }
    
}else{
     echo "<script>
     changePage('change_password.php','Error!Invalid request');
     </script>";
}
/*=====================END OF UPDATE USER PASSWORD===========================*/
?>