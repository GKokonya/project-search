<?php
require_once('../config/initialize.php');
$session = new Session();
$csrf=new Csrf();
define("ROLE","administrator");

//get the user session role 
$role = $session->role;

//if the role does not match the user he/she is taken back to login page
$session->checkRole($role,ROLE);

$session->confirm_logged_in();

//create a new product object to 
//access the product instance methods
$user = new User();
$utility=new Utility();
?>
<script src="../js/function.js"></script>
<?php
if(isset($_POST['token'])){
    $token=htmlentities($_POST['token']);
    if($csrf->checkToken($token)){
        /*============START OF CREATE CUSTOMER============================================*/
        //retrieving data from the form and inserting it into the database
        if(isset($_POST['insert'])){
            $token=$utility->generateVefificationCode(32);
            $user->setFirstName(htmlentities($_POST['first_name']));
            $user->setLastName(htmlentities($_POST['last_name']));
            $user->setEmail(htmlentities($_POST['email']));
            $user->setRole(htmlentities($_POST['role']));
            $user->setEmailVerified("1");
            $user->setAccountStatus(htmlentities($_POST['account_status']));
            $hashed_password =  $user->password_encrypt(htmlentities($_POST["password"]));
            $user->setPassword($hashed_password);
            $user->setToken($token);
            $current_datetime = date("Y-m-d H:i:s");
            $user->setCreatedAt($current_datetime);
            $user->setUpdatedAt($current_datetime);
            if($user->insert()){
              echo "<script> changePage('users.php','User created successfully')</script>";
            }else{
                  echo "<script>
             changePage('show_user.php','Failed to create User');
             </script>";
                    
            }
        }
         
        /*=====================START OF DELETE USER ===================================*/
        if(isset($_POST['deletedata'])){
            $id=htmlentities($_POST['deleteuser_id']);
    	    if($user && $user->destroy($id)){
    	        //if the delete fails the folowing erors are displayed
    	        echo "<script> changePage('users.php','user removed successfully') </script>";
    	    }else{
    		    echo "<script> changePage('users.php','Failed! Please try again later') </script>";
    	    }
        }
        /*=====================START OF DELETE USER ===================================*/
        
        /*=====================START OF UPDATE USER ===================================*/
        if(isset($_POST['editdata'])){
            $user->setUserId(htmlentities($_POST['user_id']));
            $user->setFirstName(htmlentities($_POST['first_name']));
            $user->setLastName(htmlentities($_POST['last_name']));
            $user->setEmail(htmlentities($_POST['email']));
            $user->setPhone(htmlentities($_POST['phone']));
            $user->setRole(htmlentities($_POST['role']));
            $user->setGender(htmlentities($_POST['gender']));
            $user->setEmailVerified(htmlentities($_POST['email_verified']));
             $user->setAccountStatus(htmlentities($_POST['account_status']));
            if($user->update()){
                echo "<script> changePage('users.php','user updated successfully') </script>";
            }else{
                 echo "<script> changePage('users.php','user updated successfully') </script>";
            }
            
        }
        /*=====================END OF UPDATE USER ===================================*/
        
        /*=====================START OF UPDATE USER PASSWORD===========================*/
        if(isset($_POST['editpasssworddata'])){
            $user->setId(htmlentities($_POST['user_id']));
            $hashed_password = $user->password_encrypt(htmlentities($_POST["password"]));
            $user->setPassword($hashed_password);
            if($user->updatePassword()){
                echo "<script> changePage('users.php','Password changed successfully') </script>";
                //redirect_to('show_user.php');
            }else{
                echo "<script> changePage('users.php','Failed to change Password') </script>";
            }
        }
        /*=====================END OF UPDATE USER PASSWORD===========================*/
        
        /*=====================START OF UPDATE FIRST NAME AND LAST NAME ===========================*/
        if(isset($_POST['editProfile'])){
            $id=htmlentities($_POST['user_id']);
            $first_name=htmlentities($_POST['first_name']);
            $last_name=htmlentities($_POST['last_name']);
            $user->setId($id);
            $user->setFirstName($first_name);
            $user->setLastName($last_name);
        
            if($user->updateName()){
                
                $session->UpdateSessionName($first_name,$last_name);
                echo "<script> changePage('profile.php','First and last name changed successfully') </script>";
                //redirect_to('show_user.php');
            }else{
                echo "<script> changePage('profile.php','Failed to change name') </script>";
            }
        }
        /*=====================END OF UPDATE FIRST NAME AND LAST NAME===========================*/
        
    }else{
            echo "<script>
         changePage('users.php','INVALID CSRF TOKEN!');
         </script>";
        
    }
    
}else{
     echo "<script>
     changePage('users.php','INVALID REQUEST');
     </script>";
}
?>