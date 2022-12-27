<?php
require_once('../config/initialize.php');
$session=new Session();
$inCompleteSearch=new InCompleteSearch();
$completeSearch=new CompleteSearch();
$mpesaDB=new MpesaDB();
$session->setPageTitle("admin-home");
$session->setPageDescription("This is the admin dashboard page");
//define page role
define("ROLE","administrator");
//get the user session role 
$role = $session->role;
//if the role does not match the user he/she is taken back to login page
$session->checkRole($role,ROLE);

require_once('../layouts/admin_header_template.php');
?>
<section class="dashboard-section"> 
    <div class="container-fluid px-4">
        <div class="row g-3 my-2">
            <div class="col-md-4">
                <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                    <div>
                        <h3 class="fs-2"><?php echo $inCompleteSearch->countAll();?></h3>
                        <p class="fs-5">Incomplete Searches</p>
                    </div>
                    <i class="fas fa-search fs-1 border rounded-full  p-3"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                    <div>
                        <h3 class="fs-2"><?php echo $completeSearch->countAll();?></h3>
                        <p class="fs-5">Complete Searches</p>
                    </div>
                    <i class="fas fa-search fs-1 border rounded-full  p-3"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                    <div>
                        <h3 class="fs-2"><?php echo $mpesaDB->countAll();?></h3>
                        <p class="fs-5">Mpesa Transactions</p>
                    </div>
                    
                    <i class="fas fa-hand-holding-usd fs-1 border rounded-full p-3"></i>
                </div>
            </div>
<?php
require_once('../layouts/admin_footer_template.php');
?>