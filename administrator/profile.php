<?php
require_once('../config/initialize.php');
$session=new Session();
$inCompleteSearch=new InCompleteSearch();
$completeSearch=new CompleteSearch();
$mpesaDB=new MpesaDB();
$userObj=new User();
$csrf=new Csrf();
$session->setPageTitle("profile");
$session->setPageDescription("This is the profile page");
//define page role
define("ROLE","administrator");
//get the user session role 
$role = $session->role;
//if the role does not match the user he/she is taken back to login page
$session->checkRole($role,ROLE);
$user=$userObj->getByID($session->user_id);
require_once('../layouts/admin_header_template.php');
?>
<section class="Profile-section"> 
    <div class="container-fluid px-4">
        <div class="row g-3 my-2">
            <div class="container rounded bg-white mt-5 mb-5">
                <div class="row">
                    <div class="col-md-4 border-right">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold"> <?php echo $user['first_name'].' '.$user['last_name'];?></span><span class="text-black-50">
                            <?php echo $user['email'];?>
                            </span><span> </span></div>
                    </div>
                    <div class="col-md-8 border-right">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">Profile Settings</h4>
                            </div>
                            <form action="crud_user.php" method="POST" class="needs-validation" novalidate>
                            <div class="row mt-3">
                                 <div class="col-md-12"><label class="labels">First Name</label>
                                 <input type="text" class="form-control" placeholder="First Name"  pattern="(\s*(?:\S\s*){1,20})" name="first_name"
                                 value="<?php echo $user['first_name'];?>" required/>
                                  <div class="valid-feedback">first name looks good</div>
                                    <div class="invalid-feedback">Please enter a valid first name.This field is required.</div>
                                 </div>
            
                            </div>
                            
                            <div class="row mt-3">
            
                                 <div class="col-md-12"><label class="labels">Last Name</label>
                                    <input type="text" class="form-control"  pattern="(\s*(?:\S\s*){1,20})" placeholder="Last Name"
                                 name="last_name" value="<?php echo $user['last_name'];?>" required/>
                                     <div class="valid-feedback">last name looks good</div>
                                    <div class="invalid-feedback">Please enter a valid last name.This field is required.</div>
                                 </div>
                            </div>
                            
                             <input type="hidden" name="token" value="<?php echo $csrf->generateToken();?>"/>
                            <input type="hidden" name="user_id" value="<?php echo $user['id'];?>"/>
                            
                            <div class="row mt-3">
                                <div class="mt-5 text-center"><button class="btn btn-dark profile-button" type="submit" name="editProfile">Save Profile</button></div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>
</div>
<?php
require_once('../layouts/admin_footer_template.php');
?>