<?php
require_once('../config/initialize.php');
$completeSearch=new CompleteSearch();
$session=new Session();
$session->setPageTitle("complete-search");
$session->setPageDescription("This page allows viewing of paid IMEI number searches");
//define page role
define("ROLE","administrator");
//get the user session role 
$role = $session->role;
//if the role does not match the user he/she is taken back to login page
$session->checkRole($role,ROLE);
require_once('../layouts/admin_header_template.php');
?>
<section class="incompelte-section"> 
    <div class="container-fluid px-4">
        <div class="row my-5">
            <div class="col">
                <div class="card">
                    <h3 id="create-users-header" class="text-center">Complete Search</h3>
                </div>
                <div class="card">
                    <div class="table-responsive">  
                        <table id="incomplete_search_table" class="table bg-white w-100 rounded shadow-sm  table-hover table-bordered ">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#ID</th>
                                    <th scope="col">IP Address </th>
                                    <th scope="col">User Agent </th>
                                    <th scope="col">#IMEI</th>
                                    <th scope="col">Transaction #ID</th>
                                    <th scope="col">Payment Method</th>
                                    <th scope="col">#Phone</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                    $completeSearches=$completeSearch->getAll();
                                    foreach($completeSearches as $row){
                                    echo '<tr>
                                    <td scope="col">'.$row['id'].'</td>
                                    <td scope="col">'.$row['ip_address'].'</td>
                                    <td scope="col">'.$row['user_agent'].'</td>
                                    <td scope="col">'.$row['imei_number'].'</td>
                                    <td scope="col">'.$row['transaction_id'].'</td>
                                    <td scope="col">'.$row['payment_method'].'</td>
                                    <td scope="col">'.$row['phone_number'].'</td>
                                    <td scope="col">'.$row['created_at'].'</td>
                                    </tr>
                                    ';
                                    }?>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
<?php
require_once('../layouts/admin_footer_template.php');
?>
<script>
$(document).ready(function() {
    $('#incomplete_search_table').DataTable({
        "order": [[ 0, "desc" ]]});
});
</script>