<?php
require_once('../config/initialize.php');
$mpesaDB=new MpesaDB();
$session=new Session();
$session->setPageTitle("mpesa-transactions");
$session->setPageDescription("This page allows viewing of all mpesa transactions");
//define page role
define("ROLE","administrator");
//get the user session role 
$role = $session->role;
//if the role does not match the user he/she is taken back to login page
$session->checkRole($role,ROLE);
require_once('../layouts/admin_header_template.php');
?>
<section class="mpesa-transactions-section"> 
    <div class="container-fluid px-4">
        <div class="row my-5">
            <div class="col">
                <div class="card border-top-primary">
                    <h3 id="create-users-header" class="text-center">Mpesa Transactions</h3>
                </div>
                <div class="card">
                    <div class="table-responsive">  
                        <table id="mpesa_transaction_table" class="table table-bordered  w-100 bg-white rounded shadow-sm  table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" width="50">ID</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Transaction Date</th>
                                </tr>
                            </thead>
                            <tbody>
        
                                    <?php
                                    $mpesa=$mpesaDB->getAll();
                                    foreach($mpesa as $row){
                                    echo '
                                    <tr>
                                    <td scope="col">'.$row['id'].'</td>
                                    <td scope="col">'.$row['mpesaReceiptNumber'].'</td>
                                    <td scope="col">'.$row['amount'].'</td>
                                    <td scope="col">'.$row['phoneNumber'].'</td>
                                    <td scope="col">'.$row['transactionDate'].'</td>
                                    </tr>';
                                    }
                                    ?>
                                    
                                    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

<?php
require_once('../layouts/admin_footer_template.php');
?>
<script>
$(document).ready(function() {
    $('#mpesa_transaction_table').DataTable({
        "order": [[ 0, "desc" ]]
    });
});
</script>